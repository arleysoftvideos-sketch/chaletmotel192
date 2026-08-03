<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoomControlBooking;
use Google\Client;
use Google\Service\Sheets;

class ImportBookingsFromSheets extends Command
{
    protected $signature = 'db:import-sheets-bookings {--truncate : Truncate the table before importing}';

    protected $description = 'Import bookings from Google Sheets into local SQLite database';

    private $spreadsheetId = '1_HLh9a0v70MrRMd2ZGQy9j_v41HeNI-1i8xqsyd9RXE';

    public function handle()
    {
        $this->info('Starting import of bookings from Google Sheets...');

        if ($this->option('truncate')) {
            $this->warn('Truncating room_control_bookings table...');
            // In SQLite, truncate is done by deleting all rows
            RoomControlBooking::query()->delete();
        }

        $credentialsPath = storage_path('app/google-credentials.json');

        if (!file_exists($credentialsPath)) {
            $this->error('Google credentials file not found at storage/app/google-credentials.json');
            return 1;
        }

        try {
            $client = new Client();
            $client->setApplicationName('Chalet Motel Bot');
            $client->setScopes([Sheets::SPREADSHEETS]);
            $client->setAuthConfig($credentialsPath);
            $service = new Sheets($client);

            $range = 'rooms!A2:K500';
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) {
                $this->info('No bookings found in Google Sheets.');
                return 0;
            }

            $count = 0;
            foreach ($values as $index => $row) {
                $room = $row[0] ?? null;
                $cliente = $row[1] ?? null;
                if (empty($room) || empty($cliente)) {
                    continue;
                }

                $fecha_inicio = $row[3] ?? '';
                $fecha_salida = $row[4] ?? '';
                
                $exists = false;
                if (!$this->option('truncate')) {
                    $exists = RoomControlBooking::where('room', $room)
                        ->where('cliente', $cliente)
                        ->where('fecha_inicio', $fecha_inicio)
                        ->where('fecha_salida', $fecha_salida)
                        ->exists();
                }

                if (!$exists) {
                    RoomControlBooking::create([
                        'id' => $index + 2, // Maintain identical row IDs for consistency
                        'room' => (int)$room,
                        'cliente' => $cliente,
                        'telefono' => $row[2] ?? null,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_salida' => $fecha_salida,
                        'tasa_aseo' => (float)($row[5] ?? 0),
                        'deposito' => (float)($row[6] ?? 0),
                        'total_pagado' => (float)($row[7] ?? 0),
                        'estado' => strtoupper($row[8] ?? 'ABIERTO'),
                        'notas' => $row[9] ?? null,
                        'fecha_registro' => $row[10] ?? null,
                    ]);
                    $count++;
                }
            }

            $this->info("Imported {$count} bookings successfully.");
            return 0;

        } catch (\Exception $e) {
            $this->error('Error during import: ' . $e->getMessage());
            return 1;
        }
    }
}
