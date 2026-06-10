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
        $customStores = [];

        try {
            $service = $this->getSheetsService();
            $spreadsheetId = $this->spreadsheetId;

            // Ensure sheet exists before reading
            $this->ensureStoresSheetExists($service, $spreadsheetId);

            // Fetch columns A to F from the "stores" sheet (starting at row 2)
            $range = 'stores!A2:F';
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            if (!empty($values)) {
                foreach ($values as $row) {
                    if (!empty($row[0])) {
                        $customStores[] = [
                            'n' => trim($row[0]),
                            't' => isset($row[1]) ? trim($row[1]) : 'N/A',
                            'w' => (isset($row[2]) && trim($row[2]) !== '') ? trim($row[2]) : '#',
                            'a' => (isset($row[5]) && trim($row[5]) === 'Sí') ? true : false,
                            'r' => isset($row[3]) ? trim($row[3]) : 'Volusia',
                            'e' => isset($row[4]) ? trim($row[4]) : 'Independiente'
                        ];
                    }
                }
            }

        } catch (\Exception $e) {
            // Log error or set a warning, but let the page load gracefully
            logger()->error('Error loading custom stores: ' . $e->getMessage());
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

            return redirect()->back()->with('success', '¡Tienda agregada con éxito a Google Sheets!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar en Google Sheets: ' . $e->getMessage())->withInput();
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
}
