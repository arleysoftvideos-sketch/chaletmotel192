<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Client;
use Google\Service\Sheets;
use App\Models\RecyclingStore;
use App\Models\RecyclingLog;

class SyncFromSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recycling:sync-from-sheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync custom stores and recycling logs from Google Sheets to the local database';

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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting sync from Google Sheets...');

        try {
            $service = $this->getSheetsService();
            
            // 1. Sync custom stores
            $this->info('Syncing custom stores...');
            try {
                $rangeStores = 'stores!A2:F';
                $responseStores = $service->spreadsheets_values->get($this->spreadsheetId, $rangeStores);
                $valuesStores = $responseStores->getValues();

                if (!empty($valuesStores)) {
                    $storeCount = 0;
                    foreach ($valuesStores as $row) {
                        if (!empty($row[0])) {
                            $nombre = trim($row[0]);
                            $telefono = isset($row[1]) ? trim($row[1]) : 'N/A';
                            $web = (isset($row[2]) && trim($row[2]) !== '') ? trim($row[2]) : '#';
                            $ruta = isset($row[3]) ? trim($row[3]) : 'Volusia';
                            $empresa = isset($row[4]) ? trim($row[4]) : 'Independiente';
                            $alerta = (isset($row[5]) && trim($row[5]) === 'Sí') ? 'Sí' : 'No';

                            RecyclingStore::updateOrCreate(
                                ['nombre' => $nombre],
                                [
                                    'telefono' => $telefono,
                                    'web' => $web,
                                    'ruta' => $ruta,
                                    'empresa' => $empresa,
                                    'alerta' => $alerta,
                                ]
                            );
                            $storeCount++;
                        }
                    }
                    $this->info("Successfully synced {$storeCount} custom stores.");
                } else {
                    $this->comment('No custom stores found in the stores sheet.');
                }
            } catch (\Exception $e) {
                $this->error('Failed to sync stores: ' . $e->getMessage());
            }

            // 2. Sync recycling logs
            $this->info('Syncing recycling logs...');
            try {
                $rangeRecycling = 'recycling!A2:E';
                $responseRecycling = $service->spreadsheets_values->get($this->spreadsheetId, $rangeRecycling);
                $valuesRecycling = $responseRecycling->getValues();

                if (!empty($valuesRecycling)) {
                    $logCount = 0;
                    foreach ($valuesRecycling as $row) {
                        if (!empty($row[0]) && !empty($row[1])) {
                            $date = trim($row[0]);
                            $store = trim($row[1]);
                            $big = isset($row[2]) ? (int)trim($row[2]) : 0;
                            $small = isset($row[3]) ? (int)trim($row[3]) : 0;
                            $total = isset($row[4]) ? (int)trim($row[4]) : ($big + $small);

                            try {
                                $formattedDate = date('Y-m-d', strtotime($date));
                            } catch (\Exception $e) {
                                $formattedDate = $date;
                            }

                            RecyclingLog::updateOrCreate(
                                [
                                    'date' => $formattedDate,
                                    'store' => $store,
                                ],
                                [
                                    'big' => $big,
                                    'small' => $small,
                                    'total' => $total,
                                ]
                            );
                            $logCount++;
                        }
                    }
                    $this->info("Successfully synced {$logCount} recycling logs.");
                } else {
                    $this->comment('No recycling logs found in the recycling sheet.');
                }
            } catch (\Exception $e) {
                $this->error('Failed to sync recycling logs: ' . $e->getMessage());
            }

            $this->info('Sync complete!');

        } catch (\Exception $e) {
            $this->error('Connection error: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
