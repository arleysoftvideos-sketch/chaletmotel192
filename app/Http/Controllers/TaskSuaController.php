<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\DriveFile;

class TaskSuaController extends Controller
{
    /**
     * Muestra la interfaz de Captura POV 4K (Full Screen Inmersiva)
     */
    public function index(Request $request)
    {
        $taskId           = $request->query('task_id', null);
        $taskTitle        = $request->query('task_title', 'Grabación POV Libre');
        $category         = $request->query('category', 'General');
        $targetResolution = $request->query('res', '4K');

        return view('tasksua.capture', compact('taskId', 'taskTitle', 'category', 'targetResolution'));
    }

    /**
     * Recibe el video POV y los metadatos de TaskSua.
     * Guarda en la Bóveda del Servidor + Sube a Google Drive.
     * POST /tasksua/upload
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('video')) {
            return response()->json(['error' => 'No se recibió archivo de video.'], 422);
        }

        $videoFile  = $request->file('video');
        $metaRaw    = $request->input('metadata', '{}');
        $metadata   = json_decode($metaRaw, true) ?? [];

        $now        = now();
        $dateStr    = $now->format('Y-m-d_H-i-s');
        $taskId     = $metadata['task_id'] ?? ('TSK-' . $now->format('Y-md') . '-' . rand(1000, 9999));
        $ext        = $videoFile->getClientOriginalExtension() ?: 'webm';
        $filename   = "TaskSua_POV_{$dateStr}.{$ext}";
        $jsonName   = "{$taskId}_metadata.json";

        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        // ── 1. Guardar de inmediato en la Bóveda Local del Servidor (Vault Backup) ──
        $vaultDir = 'public/vault';
        Storage::makeDirectory("{$vaultDir}/videos");
        Storage::makeDirectory("{$vaultDir}/metadata");

        $storedPath = $videoFile->storeAs("{$vaultDir}/videos", $filename);
        $vaultUrl   = url("storage/vault/videos/{$filename}");

        // ── Construir metadata completo TaskSua ──
        $taskJson = array_merge([
            'task_id'  => $taskId,
            'platform' => 'TaskSua',
        ], $metadata);

        $taskJson['sync_status']['local_vault_path'] = $storedPath;
        $taskJson['sync_status']['vault_url']        = $vaultUrl;
        $taskJson['sync_status']['uploaded']         = true;
        $taskJson['sync_status']['cloud_url']        = $vaultUrl;
        $taskJson['capture_metadata']['file_name']   = $filename;
        $taskJson['capture_metadata']['file_size_bytes'] = $videoFile->getSize();

        // Guardar JSON en la bóveda
        Storage::put("{$vaultDir}/metadata/{$jsonName}", json_encode($taskJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // ── 2. Intentar subida a Google Drive ──
        $driveUrl = null;
        $driveId  = null;

        try {
            $credPath = storage_path('app/credentials/google-service-account.json');

            if (file_exists($credPath)) {
                $client = new GoogleClient();
                $client->setAuthConfig($credPath);
                $client->addScope(GoogleDrive::DRIVE);
                $client->setApplicationName('TaskSua POV Vault');

                $drive    = new GoogleDrive($client);
                $folderId = env('GOOGLE_DRIVE_FOLDER_ID', '1EJ6QnBrV7qdOvONkhMBJX3wnDyNUPu1A');

                $videoContent = file_get_contents($videoFile->getRealPath());

                $videoMeta = new DriveFile([
                    'name'        => $filename,
                    'parents'     => [$folderId],
                    'description' => "TaskSua POV | {$taskId} | " . ($metadata['capture_metadata']['duration_formatted'] ?? '')
                ]);

                $videoResult = $drive->files->create(
                    $videoMeta,
                    [
                        'data'              => $videoContent,
                        'mimeType'          => $videoFile->getMimeType() ?: 'video/webm',
                        'uploadType'        => 'multipart',
                        'supportsAllDrives' => true,
                        'fields'            => 'id,name,webViewLink'
                    ]
                );

                $driveUrl = $videoResult->getWebViewLink();
                $driveId  = $videoResult->getId();

                // Subir JSON a Drive
                $taskJson['sync_status']['cloud_url']     = $driveUrl;
                $taskJson['sync_status']['drive_file_id'] = $driveId;

                $jsonMeta = new DriveFile([
                    'name'              => $jsonName,
                    'parents'           => [$folderId],
                    'mimeType'          => 'application/json'
                ]);

                $drive->files->create(
                    $jsonMeta,
                    [
                        'data'              => json_encode($taskJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                        'mimeType'          => 'application/json',
                        'uploadType'        => 'multipart',
                        'supportsAllDrives' => true
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::warning('[TaskSua Drive Warning - Guardado en Boveda] ' . $e->getMessage());
            // No fallamos la petición: el archivo ya está en la Bóveda del Servidor
        }

        return response()->json([
            'success'       => true,
            'task_id'       => $taskId,
            'file_name'     => $filename,
            'drive_url'     => $driveUrl ?: $vaultUrl,
            'vault_url'     => $vaultUrl,
            'drive_file_id' => $driveId,
            'json_saved'    => $jsonName,
            'message'       => 'Video y metadatos asegurados con éxito.'
        ]);
    }
}
