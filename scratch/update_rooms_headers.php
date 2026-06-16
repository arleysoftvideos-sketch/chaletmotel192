<?php

require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

$credentialsPath = __DIR__ . '/../storage/app/google-credentials.json';
$spreadsheetId = '1_HLh9a0v70MrRMd2ZGQy9j_v41HeNI-1i8xqsyd9RXE';

if (!file_exists($credentialsPath)) {
    die("No se encontró el archivo de credenciales de Google en storage/app/google-credentials.json\n");
}

$client = new Client();
$client->setApplicationName('Chalet Motel Bot');
$client->setScopes([Sheets::SPREADSHEETS]);
$client->setAuthConfig($credentialsPath);

$service = new Sheets($client);

// Headers to write
$headers = [
    'room',
    'cliente',
    'telefono',
    'fecha_inicio',
    'fecha_salida',
    'tasa_aseo',
    'deposito',
    'total_pagado',
    'estado',
    'notas',
    'fecha_registro'
];

$range = 'rooms!A1:K1';
$body = new ValueRange([
    'values' => [$headers]
]);

try {
    $response = $service->spreadsheets_values->update($spreadsheetId, $range, $body, [
        'valueInputOption' => 'USER_ENTERED'
    ]);
    echo "¡Columnas agregadas con éxito a la pestaña 'rooms'!\n";
    echo "Celdas actualizadas: " . $response->getUpdatedCells() . "\n";
} catch (\Exception $e) {
    echo "Error al actualizar la hoja de cálculo: " . $e->getMessage() . "\n";
}
