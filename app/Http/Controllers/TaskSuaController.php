<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Google\Service\Drive\DriveFile;

class TaskSuaController extends Controller
{
    /**
     * Muestra la interfaz del Núcleo de Captura 4K de TaskSua (100% aislada, sin nada del motel)
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
     * Recibe el video POV y los metadatos de TaskSua y los sube a Google Drive
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

        $taskJson = array_merge([
            'task_id'  => $taskId,
            'platform' => 'TaskSua',
        ], $metadata);

        $taskJson['sync_status']['uploaded'] = false;
        $taskJson['sync_status']['cloud_url'] = null;
        $taskJson['capture_metadata']['file_name'] = $filename;
        $taskJson['capture_metadata']['file_size_bytes'] = $videoFile->getSize();

        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        try {
            $credPath = storage_path('app/credentials/google-service-account.json');

            if (!file_exists($credPath)) {
                return response()->json([
                    'error' => 'Credenciales de Google no encontradas en storage/app/credentials/'
                ], 500);
            }

            $client = new GoogleClient();
            $client->setAuthConfig($credPath);
            $client->addScope(GoogleDrive::DRIVE);
            $client->setApplicationName('TaskSua POV Vault');

            $drive    = new GoogleDrive($client);
            $folderId = env('GOOGLE_DRIVE_FOLDER_ID', '1EJ6QnBrV7qdOvONkhMBJX3wnDyNUPu1A');

            $videoMeta = new DriveFile([
                'name'        => $filename,
                'parents'     => [$folderId],
                'description' => "TaskSua POV | {$taskId} | " . ($metadata['capture_metadata']['duration_formatted'] ?? '')
            ]);

            $fileHandle = fopen($videoFile->getRealPath(), 'rb');

            $videoResult = $drive->files->create(
                $videoMeta,
                [
                    'data'              => $fileHandle,
                    'mimeType'          => $videoFile->getMimeType() ?: 'video/webm',
                    'uploadType'        => 'multipart',
                    'supportsAllDrives' => true,
                    'fields'            => 'id,name,webViewLink'
                ]
            );

            if (is_resource($fileHandle)) {
                fclose($fileHandle);
            }

            $webViewLink = $videoResult->getWebViewLink();

            // Guardar JSON compañero en Drive
            $taskJson['sync_status']['uploaded']      = true;
            $taskJson['sync_status']['cloud_url']     = $webViewLink;
            $taskJson['sync_status']['drive_file_id'] = $videoResult->getId();

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

            return response()->json([
                'success'       => true,
                'task_id'       => $taskId,
                'file_name'     => $filename,
                'drive_url'     => $webViewLink,
                'drive_file_id' => $videoResult->getId(),
                'json_saved'    => $jsonName,
                'message'       => 'Video y JSON guardados en Drive. Celular libre.'
            ]);

        } catch (\Exception $e) {
            Log::error('[TaskSua Upload Error] ' . $e->getMessage());
            return response()->json([
                'error'   => 'Error Drive: ' . $e->getMessage(),
                'task_id' => $taskId
            ], 500);
        }
    }
}
