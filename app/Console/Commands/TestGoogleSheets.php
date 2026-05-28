<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestGoogleSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-google-sheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting connection test...');
        
        try {
            $client = new \Google\Client();
            $client->setApplicationName('Chalet Motel Bot');
            $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
            $client->setAuthConfig(storage_path('app/google-credentials.json'));
            
            $service = new \Google\Service\Sheets($client);
            $spreadsheetId = '1_HLh9a0v70MrRMd2ZGQy9j_v41HeNI-1i8xqsyd9RXE';
            
            $spreadsheet = $service->spreadsheets->get($spreadsheetId);
            $sheets = $spreadsheet->getSheets();
            
            $this->info('Successfully connected to spreadsheet: ' . $spreadsheet->getProperties()->getTitle());
            
            foreach ($sheets as $sheet) {
                $title = $sheet->getProperties()->getTitle();
                $this->info("Sheet found: {$title}");
                
                // Get the first 5 rows to see what is there
                $range = $title . '!A1:Z5';
                $response = $service->spreadsheets_values->get($spreadsheetId, $range);
                $values = $response->getValues();
                
                if (empty($values)) {
                    $this->warn("  Sheet '{$title}' is empty.");
                } else {
                    $this->info("  First row headers: " . implode(', ', $values[0]));
                    $this->info("  Total rows found: " . count($values));
                }
            }
            
        } catch (\Exception $e) {
            $this->error('Connection failed: ' . $e->getMessage());
        }
    }
}
