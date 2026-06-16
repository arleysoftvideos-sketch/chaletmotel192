<?php

require __DIR__ . '/../vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;

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

try {
    // 1. Get the sheetId of the 'rooms' sheet
    $spreadsheet = $service->spreadsheets->get($spreadsheetId);
    $sheets = $spreadsheet->getSheets();
    $sheetId = null;
    foreach ($sheets as $s) {
        if ($s->getProperties()->getTitle() === 'rooms') {
            $sheetId = $s->getProperties()->getSheetId();
            break;
        }
    }

    if ($sheetId === null) {
        die("No se encontró la pestaña 'rooms' en la hoja de cálculo.\n");
    }

    // 2. Prepare the list of room values for the dropdown
    $dropdownValues = [];
    for ($i = 101; $i <= 114; $i++) {
        $dropdownValues[] = ['userEnteredValue' => (string)$i];
    }
    for ($i = 201; $i <= 214; $i++) {
        $dropdownValues[] = ['userEnteredValue' => (string)$i];
    }

    // 3. Create the Data Validation request
    $request = new Request([
        'setDataValidation' => [
            'range' => [
                'sheetId' => $sheetId,
                'startRowIndex' => 1, // Row 2 (0-indexed)
                'endRowIndex' => 500,  // Rows 2 to 500
                'startColumnIndex' => 0, // Column A (0-indexed)
                'endColumnIndex' => 1
            ],
            'rule' => [
                'condition' => [
                    'type' => 'ONE_OF_LIST',
                    'values' => $dropdownValues
                ],
                'showCustomUi' => true,
                'strict' => true
            ]
        ]
    ]);

    $batchUpdateRequest = new BatchUpdateSpreadsheetRequest([
        'requests' => [$request]
    ]);

    $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    echo "¡Desplegable de habitaciones (101-114 y 201-214) agregado con éxito a la columna A (rows 2-500)!\n";

} catch (\Exception $e) {
    echo "Error al agregar la validación de datos: " . $e->getMessage() . "\n";
}
