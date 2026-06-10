<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class RecyclingController extends Controller
{
    private $spreadsheetId = '1_HLh9a0v70MrRMd2ZGQy9j_v41HeNI-1i8xqsyd9RXE';

    private function getSheetsService()
    {
        $credentialsPath = storage_path('app/google-credentials.json');

        if (!file_exists($credentialsPath)) {
            throw new \Exception('No se encontró el archivo de credenciales de Google en storage/app/google-credentials.json');
        }

        $client = new Client();
        $client->setApplicationName('Chalet Motel Bot');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentialsPath);

        return new Sheets($client);
    }

    public function index()
    {
        $this->autoSync();
        $customStores = [];

        try {
            $stores = \App\Models\RecyclingStore::all();
            foreach ($stores as $store) {
                $customStores[] = [
                    'n' => trim($store->nombre),
                    't' => $store->telefono ?? 'N/A',
                    'w' => ($store->web && trim($store->web) !== '') ? trim($store->web) : '#',
                    'a' => $store->alerta === 'Sí' ? true : false,
                    'r' => $store->ruta ?? 'Volusia',
                    'e' => $store->empresa ?? 'Independiente'
                ];
            }
        } catch (\Exception $e) {
            logger()->error('Error loading custom stores from database: ' . $e->getMessage());
        }

        return view('recycling', compact('customStores'));
    }

    public function saveToSheets(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:50',
            'web' => 'required|string|max:255',
            'ruta' => 'required|string|in:Volusia,Orlando,Kissimmee,Lakeland,Miami,Ft. Lauderdale',
            'empresa' => 'required|string|max:255',
            'alerta' => 'required|string|in:Sí,No',
        ]);

        try {
            // Save to Local Database
            \App\Models\RecyclingStore::updateOrCreate(
                ['nombre' => $request->input('nombre')],
                [
                    'telefono' => $request->input('telefono'),
                    'web' => $request->input('web'),
                    'ruta' => $request->input('ruta'),
                    'empresa' => $request->input('empresa'),
                    'alerta' => $request->input('alerta'),
                ]
            );

            // Sync with Google Sheets
            try {
                $service = $this->getSheetsService();
                $spreadsheetId = $this->spreadsheetId;

                // Ensure "stores" sheet exists
                $this->ensureStoresSheetExists($service, $spreadsheetId);

                $row = [
                    $request->input('nombre'),
                    $request->input('telefono'),
                    $request->input('web'),
                    $request->input('ruta'),
                    $request->input('empresa'),
                    $request->input('alerta'),
                    date('Y-m-d H:i:s')
                ];

                $range = 'stores!A:G';
                $body = new ValueRange([
                    'values' => [$row]
                ]);

                $service->spreadsheets_values->append($spreadsheetId, $range, $body, [
                    'valueInputOption' => 'USER_ENTERED'
                ]);
            } catch (\Exception $sheetEx) {
                logger()->error('Failed to sync custom store to Google Sheets: ' . $sheetEx->getMessage());
                return redirect()->back()->with('success', '¡Tienda guardada en base de datos local! (No se pudo sincronizar temporalmente con Google Sheets).');
            }

            return redirect()->back()->with('success', '¡Tienda agregada con éxito a la base de datos y Google Sheets!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar: ' . $e->getMessage())->withInput();
        }
    }

    public function getStats(Request $request)
    {
        $this->autoSync();
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query = \App\Models\RecyclingLog::query();

            if ($startDate) {
                $query->where('date', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('date', '<=', $endDate);
            }

            $totalBig = (int)$query->sum('big');
            $totalSmall = (int)$query->sum('small');
            $totalBags = (int)$query->sum('total');
            $logCount = (int)$query->count();

            // Group by store and summarize
            $topLocations = $query->select('store', 
                \DB::raw('SUM(big) as big_sum'), 
                \DB::raw('SUM(small) as small_sum'), 
                \DB::raw('SUM(total) as total_sum')
            )
            ->groupBy('store')
            ->orderBy('total_sum', 'desc')
            ->get();

            // Get recent logs
            $recentLogs = $query->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            return response()->json([
                'success' => true,
                'summary' => [
                    'big' => $totalBig,
                    'small' => $totalSmall,
                    'total' => $totalBags,
                    'count' => $logCount,
                ],
                'locations' => $topLocations,
                'logs' => $recentLogs,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    private function ensureStoresSheetExists(Sheets $service, $spreadsheetId)
    {
        $spreadsheet = $service->spreadsheets->get($spreadsheetId);
        $sheets = $spreadsheet->getSheets();
        $sheetTitles = [];
        foreach ($sheets as $s) {
            $sheetTitles[] = $s->getProperties()->getTitle();
        }

        if (!in_array('stores', $sheetTitles)) {
            $requests = [
                new \Google\Service\Sheets\Request([
                    'addSheet' => [
                        'properties' => ['title' => 'stores']
                    ]
                ])
            ];

            $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);
            $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);

            // Initialize headers
            $range = 'stores!A1:G1';
            $headers = ['Nombre', 'Teléfono', 'Web', 'Ruta', 'Empresa', 'Alerta', 'Fecha Registro'];
            $body = new ValueRange(['values' => [$headers]]);
            $service->spreadsheets_values->update($spreadsheetId, $range, $body, [
                'valueInputOption' => 'USER_ENTERED'
            ]);
        }
    }

    private function autoSync()
    {
        if (app()->environment('testing')) {
            return;
        }

        try {
            $lockKey = 'recycling_sync_lock';
            $lastSyncKey = 'recycling_last_sync_time';
            
            $currentTime = time();
            $lastSyncTime = \Illuminate\Support\Facades\Cache::get($lastSyncKey, 0);
            
            if (($currentTime - $lastSyncTime) > 60) {
                if (\Illuminate\Support\Facades\Cache::add($lockKey, true, 30)) {
                    \Illuminate\Support\Facades\Artisan::call('recycling:sync-from-sheets');
                    \Illuminate\Support\Facades\Cache::put($lastSyncKey, $currentTime, 3600);
                    \Illuminate\Support\Facades\Cache::forget($lockKey);
                }
            }
        } catch (\Exception $syncEx) {
            logger()->error('Auto-sync from Sheets failed: ' . $syncEx->getMessage());
        }
    }
}
