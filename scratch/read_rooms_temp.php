<?php
require __DIR__ . '/../vendor/autoload.php';

$credentialsPath = __DIR__ . '/../storage/app/google-credentials.json';
$spreadsheetId = '1_HLh9a0v70MrRMd2ZGQy9j_v41HeNI-1i8xqsyd9RXE';

$client = new Google\Client();
$client->setAuthConfig($credentialsPath);
$client->setScopes([Google\Service\Sheets::SPREADSHEETS]);
$service = new Google\Service\Sheets($client);

try {
    $spreadsheet = $service->spreadsheets->get($spreadsheetId);
    $sheets = $spreadsheet->getSheets();
    foreach ($sheets as $s) {
        echo $s->getProperties()->getTitle() . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
