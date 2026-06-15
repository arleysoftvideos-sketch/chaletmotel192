<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetController extends Controller
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

    public function syncRoom(Request $request)
    {
        $request->validate([
            'room' => 'required|integer',
            'data' => 'present|array'
        ]);

        $room = $request->input('room');
        $data = $request->input('data');

        try {
            $service = $this->getSheetsService();
            $spreadsheetId = $this->spreadsheetId;

            // 1. Ensure sheets "Estado Actual" and "Historial" exist
            $this->ensureSheetsExist($service, $spreadsheetId);

            // 2. Format the room details
            $formattedRow = $this->formatRoomData($room, $data);

            // 3. Update "Estado Actual" sheet in the specific row
            $rowIndex = $this->getRoomRowIndex($room);
            if ($rowIndex) {
                $range = "Estado Actual!A{$rowIndex}:I{$rowIndex}";
                $body = new ValueRange([
                    'values' => [$formattedRow]
                ]);
                $service->spreadsheets_values->update($spreadsheetId, $range, $body, [
                    'valueInputOption' => 'USER_ENTERED'
                ]);
            }

            // 4. Append to "Historial" sheet
            $historyRow = array_merge([date('Y-m-d H:i:s')], $formattedRow);
            $historyRange = "Historial!A:J";
            $historyBody = new ValueRange([
                'values' => [$historyRow]
            ]);
            $service->spreadsheets_values->append($spreadsheetId, $historyRange, $historyBody, [
                'valueInputOption' => 'USER_ENTERED'
            ]);

            return response()->json([
                'success' => true,
                'message' => "Habitación {$room} sincronizada con Google Sheets correctamente."
            ]);

        } catch (\Google\Service\Exception $e) {
            $errorObj = json_decode($e->getMessage(), true);
            if (isset($errorObj['error']['message']) && str_contains($errorObj['error']['message'], 'has not been used in project')) {
                return response()->json([
                    'success' => false,
                    'error_type' => 'api_disabled',
                    'message' => 'La API de Google Sheets no está habilitada. Por favor, ve al siguiente enlace para habilitarla en tu Consola de Google Cloud: https://console.developers.google.com/apis/api/sheets.googleapis.com/overview?project=jovan-gprh'
                ], 403);
            }
            return response()->json([
                'success' => false,
                'message' => 'Error de Google Sheets: ' . ($errorObj['error']['message'] ?? $e->getMessage())
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function parseRow($row)
    {
        $estado = isset($row[1]) ? strtolower($row[1]) : '';
        if ($estado !== 'limpio' && $estado !== 'sucio') {
            return null;
        }

        $camasRaw = isset($row[2]) ? $row[2] : '';
        $camas = str_starts_with($camasRaw, '2') ? '2' : '1';
        
        $bano = null;
        if (str_contains($camasRaw, 'Bañera')) {
            $bano = 'banera';
        } elseif (str_contains($camasRaw, 'Ducha sola') || str_contains($camasRaw, 'Ducha')) {
            $bano = 'ducha';
        }

        $inspector = isset($row[3]) && $row[3] !== 'N/A' ? $row[3] : '';
        $fecha = isset($row[4]) ? $row[4] : '';

        $maintRaw = isset($row[5]) ? $row[5] : '';
        $ac = null;
        if (str_contains($maintRaw, 'Aire acondicionado trabaja')) {
            $ac = 'si';
        } elseif (str_contains($maintRaw, 'Aire acondicionado no trabaja')) {
            $ac = 'no';
        }

        $chk_remiendo = str_contains($maintRaw, 'Falta remiendo/parche');
        $chk_pintura = str_contains($maintRaw, 'Requiere retoque pintura');

        $maintParts = explode('|', $maintRaw);
        $customMaintParts = [];
        foreach ($maintParts as $part) {
            $trimmed = trim($part);
            if (
                $trimmed !== 'Falta remiendo/parche' && 
                $trimmed !== 'Requiere retoque pintura' && 
                $trimmed !== 'Aire acondicionado trabaja' && 
                $trimmed !== 'Aire acondicionado no trabaja' && 
                $trimmed !== 'Ninguno' && 
                $trimmed !== ''
            ) {
                $customMaintParts[] = $trimmed;
            }
        }
        $txt_mantenimiento = implode(' | ', $customMaintParts);

        $faltantesRaw = isset($row[6]) ? $row[6] : '';
        $faltantesArray = array_map('trim', explode(',', $faltantesRaw));

        $notas = isset($row[7]) && $row[7] !== 'N/A' ? $row[7] : '';

        $requiredItems = [
            'chk_cortina' => 'Cortina',
            'chk_mesa' => 'Mesa',
            'chk_silla' => 'Silla',
            'chk_nevera' => 'Nevera',
            'chk_parrilla' => 'Portaequipajes',
            'chk_lamparas_hab' => 'Lámparas hab.',
            'chk_outlet_ac' => 'Enchufe A/C',
            'chk_tv' => 'Televisor',
            'chk_tapas_emergencia' => 'Tapas emergencia',
            'chk_covers_outlets' => 'Tapas enchufes',
            'chk_covers_luces' => 'Tapas luces',
            'chk_extractor' => 'Detector humo',
            'chk_puerta' => 'Puerta principal',
            'chk_stop_door' => 'Tope puerta',
            'chk_paredes' => 'Paredes bien',
            'chk_griferia' => 'Grifería baño',
            'chk_lavamanos' => 'Lavamanos',
            'chk_espejo' => 'Espejo',
            'chk_toilet' => 'Inodoro',
            'chk_coso_papel' => 'Set de baño',
            'chk_lampara_bano' => 'Lámpara baño',
            'chk_cover_extractor' => 'Tapa extractor baño'
        ];

        $formData = [
            'estado' => $estado,
            'camas' => $camas,
            'ac' => $ac,
            'bano' => $bano,
            'inspector' => $inspector,
            'fecha' => $fecha,
            'chk_remiendo' => $chk_remiendo,
            'chk_pintura' => $chk_pintura,
            'txt_mantenimiento' => $txt_mantenimiento,
            'txt_notas' => $notas
        ];

        foreach ($requiredItems as $key => $name) {
            $isMissing = false;
            foreach ($faltantesArray as $f) {
                if (strcasecmp($f, $name) === 0) {
                    $isMissing = true;
                    break;
                }
            }
            $formData[$key] = !$isMissing;
        }

        return $formData;
    }

    public function loadRoom($room)
    {
        try {
            $service = $this->getSheetsService();
            $spreadsheetId = $this->spreadsheetId;

            $rowIndex = $this->getRoomRowIndex($room);
            if (!$rowIndex) {
                return response()->json(['success' => false, 'message' => 'Número de habitación inválido.'], 400);
            }

            $range = "Estado Actual!A{$rowIndex}:I{$rowIndex}";
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values) || empty($values[0])) {
                return response()->json([
                    'success' => true,
                    'exists' => false,
                    'data' => null
                ]);
            }

            $formData = $this->parseRow($values[0]);

            if (is_null($formData)) {
                return response()->json([
                    'success' => true,
                    'exists' => false,
                    'data' => null
                ]);
            }

            return response()->json([
                'success' => true,
                'exists' => true,
                'data' => $formData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar habitación de Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }

    public function loadAllRooms()
    {
        try {
            $service = $this->getSheetsService();
            $spreadsheetId = $this->spreadsheetId;

            $range = "Estado Actual!A2:I29";
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            $allRoomsData = [];

            if (!empty($values)) {
                foreach ($values as $row) {
                    if (empty($row) || !isset($row[0])) {
                        continue;
                    }
                    $room = (int)$row[0];
                    $parsed = $this->parseRow($row);
                    if ($parsed) {
                        $allRoomsData[$room] = $parsed;
                    } else {
                        $allRoomsData[$room] = (object)[];
                    }
                }
            }

            // Completar con las habitaciones faltantes
            for ($room = 101; $room <= 114; $room++) {
                if (!isset($allRoomsData[$room])) {
                    $allRoomsData[$room] = (object)[];
                }
            }
            for ($room = 201; $room <= 214; $room++) {
                if (!isset($allRoomsData[$room])) {
                    $allRoomsData[$room] = (object)[];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $allRoomsData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar todas las habitaciones de Google Sheets: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getRoomRowIndex($room)
    {
        if ($room >= 101 && $room <= 114) {
            return $room - 101 + 2; // room 101 is row 2
        } elseif ($room >= 201 && $room <= 214) {
            return $room - 201 + 16; // room 201 is row 16
        }
        return null;
    }

    private function formatRoomData($room, $data)
    {
        $estado = isset($data['estado']) ? strtoupper($data['estado']) : 'NO ESPECIFICADO';
        $camas = isset($data['camas']) ? $data['camas'] . ' Cama(s)' : 'N/A';
        if (isset($data['bano'])) {
            if ($data['bano'] === 'banera') {
                $camas .= ' / Bañera';
            } elseif ($data['bano'] === 'ducha') {
                $camas .= ' / Ducha sola';
            }
        }
        $inspector = isset($data['inspector']) && $data['inspector'] !== '' ? $data['inspector'] : 'N/A';
        $fecha = isset($data['fecha']) && $data['fecha'] !== '' ? $data['fecha'] : date('Y-m-d');
        
        // Mantenimiento
        $maintList = [];
        if (isset($data['ac'])) {
            if ($data['ac'] === 'si') {
                $maintList[] = 'Aire acondicionado trabaja';
            } elseif ($data['ac'] === 'no') {
                $maintList[] = 'Aire acondicionado no trabaja';
            }
        }
        if (!empty($data['chk_remiendo'])) $maintList[] = 'Falta remiendo/parche';
        if (!empty($data['chk_pintura'])) $maintList[] = 'Requiere retoque pintura';
        if (isset($data['txt_mantenimiento']) && trim($data['txt_mantenimiento']) !== '') {
            $maintList[] = trim($data['txt_mantenimiento']);
        }
        $mantenimiento = count($maintList) > 0 ? implode(' | ', $maintList) : 'Ninguno';

        // Faltantes (unchecked required items)
        $requiredItems = [
            'chk_cortina' => 'Cortina',
            'chk_mesa' => 'Mesa',
            'chk_silla' => 'Silla',
            'chk_nevera' => 'Nevera',
            'chk_parrilla' => 'Portaequipajes',
            'chk_lamparas_hab' => 'Lámparas hab.',
            'chk_outlet_ac' => 'Enchufe A/C',
            'chk_tv' => 'Televisor',
            'chk_tapas_emergencia' => 'Tapas emergencia',
            'chk_covers_outlets' => 'Tapas enchufes',
            'chk_covers_luces' => 'Tapas luces',
            'chk_extractor' => 'Detector humo',
            'chk_puerta' => 'Puerta principal',
            'chk_stop_door' => 'Tope puerta',
            'chk_paredes' => 'Paredes bien',
            'chk_griferia' => 'Grifería baño',
            'chk_lavamanos' => 'Lavamanos',
            'chk_espejo' => 'Espejo',
            'chk_toilet' => 'Inodoro',
            'chk_coso_papel' => 'Set de baño',
            'chk_lampara_bano' => 'Lámpara baño',
            'chk_cover_extractor' => 'Tapa extractor baño'
        ];

        $missingItems = [];
        foreach ($requiredItems as $key => $name) {
            // Ignore table/chair if 2 beds (as per JS rules)
            if (isset($data['camas']) && $data['camas'] === '2' && ($key === 'chk_mesa' || $key === 'chk_silla')) {
                continue;
            }
            if (empty($data[$key])) {
                $missingItems[] = $name;
            }
        }
        $faltantes = count($missingItems) > 0 ? implode(', ', $missingItems) : 'Ninguno (Perfecto)';

        $notas = isset($data['txt_notas']) && trim($data['txt_notas']) !== '' ? trim($data['txt_notas']) : 'N/A';
        $actualizado = date('Y-m-d H:i:s');

        return [
            $room,
            $estado,
            $camas,
            $inspector,
            $fecha,
            $mantenimiento,
            $faltantes,
            $notas,
            $actualizado
        ];
    }

    private function ensureSheetsExist(Sheets $service, $spreadsheetId)
    {
        $spreadsheet = $service->spreadsheets->get($spreadsheetId);
        $sheets = $spreadsheet->getSheets();
        $sheetTitles = [];
        foreach ($sheets as $s) {
            $sheetTitles[] = $s->getProperties()->getTitle();
        }

        $requests = [];

        // 1. Create "Estado Actual" sheet if missing
        if (!in_array('Estado Actual', $sheetTitles)) {
            $requests[] = new \Google\Service\Sheets\Request([
                'addSheet' => [
                    'properties' => ['title' => 'Estado Actual']
                ]
            ]);
        }

        // 2. Create "Historial" sheet if missing
        if (!in_array('Historial', $sheetTitles)) {
            $requests[] = new \Google\Service\Sheets\Request([
                'addSheet' => [
                    'properties' => ['title' => 'Historial']
                ]
            ]);
        }

        if (count($requests) > 0) {
            $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);
            $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
        }

        // Initialize headers if empty
        $this->initializeHeaders($service, $spreadsheetId);
    }

    private function initializeHeaders(Sheets $service, $spreadsheetId)
    {
        // Headers for Estado Actual
        $range = 'Estado Actual!A1:I1';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        if (empty($response->getValues())) {
            $headers = ['Habitación', 'Estado', 'Camas', 'Inspector', 'Fecha de Inspección', 'Mantenimiento Pendiente', 'Faltantes / Daños', 'Notas', 'Actualizado El'];
            $body = new ValueRange(['values' => [$headers]]);
            $service->spreadsheets_values->update($spreadsheetId, $range, $body, ['valueInputOption' => 'USER_ENTERED']);

            // Pre-fill the 28 room rows with placeholders
            $placeholderRows = [];
            for ($room = 101; $room <= 114; $room++) {
                $placeholderRows[] = [$room, 'PENDIENTE', '', '', '', '', '', '', ''];
            }
            for ($room = 201; $room <= 214; $room++) {
                $placeholderRows[] = [$room, 'PENDIENTE', '', '', '', '', '', '', ''];
            }
            $fillRange = 'Estado Actual!A2:I29';
            $fillBody = new ValueRange(['values' => $placeholderRows]);
            $service->spreadsheets_values->update($spreadsheetId, $fillRange, $fillBody, ['valueInputOption' => 'USER_ENTERED']);
        }

        // Headers for Historial
        $historyRange = 'Historial!A1:J1';
        $historyResponse = $service->spreadsheets_values->get($spreadsheetId, $historyRange);
        if (empty($historyResponse->getValues())) {
            $headers = ['Fecha Registro', 'Habitación', 'Estado', 'Camas', 'Inspector', 'Fecha de Inspección', 'Mantenimiento Pendiente', 'Faltantes / Daños', 'Notas', 'Actualizado El'];
            $body = new ValueRange(['values' => [$headers]]);
            $service->spreadsheets_values->update($spreadsheetId, $historyRange, $body, ['valueInputOption' => 'USER_ENTERED']);
        }
    }

    public function getRecyclingStores()
    {
        $defaultStores = [
            'Angel Thrift',
            'Apopka Thrift',
            'Amvets Thrift Store',
            'Bargain Box',
            'BP',
            'Care & Share',
            'CARWASH',
            'Christian Sharing Center',
            'Citgo',
            'Citgo / Punto Conv.',
            'Community Thrift',
            'Community Thrift (Leesburg)',
            'Discovery Shop',
            'EPIPHANY THRIFT STORE',
            'Epiphany Thrift Store',
            'Faith Neighborhood',
            'Faith Thrift',
            'Founders Thrift (Lake Mary)',
            'Goodwill',
            'Goodwill (Clermont)',
            'Goodwill (Hialeah)',
            'Goodwill (Kissimmee)',
            'Goodwill (Orange City)',
            'Goodwill (Winter Park)',
            'Goodwill (Miami Beach)',
            'Goodwill (Ft Laud)',
            'Goodwill South FL',
            'Goodwill Xpress (Lake Mary)',
            'Grace Thrift',
            'Habitat ReStore',
            'Habitat ReStore (DeLand)',
            'Habitat ReStore (East)',
            'Habitat ReStore (Homestead)',
            'Habitat ReStore (Kissimmee)',
            'Helping Hand (Eustis)',
            'Helping Hearts',
            'Helping Hands (Ft Laud)',
            'Helping Hands (Hialeah)',
            'Helping Hands (Miami Beach)',
            'Hope & Help Thrift',
            'Hope Thrift',
            'Hope Thrift (Hollywood)',
            'Hope Thrift (Kendall)',
            'Hope Thrift (N Miami)',
            'Jewish Family Services',
            'Joy Thrift',
            'Miami Rescue Mission',
            'Mustard Seed',
            'Neighborhood of West Volusia',
            'New Life Thrift (Rockledge)',
            'Offset Store',
            'Ormond',
            'Ormond Beach',
            'OUR LADY LOARDS',
            'OUT FATHERS CLOSET',
            'Out Father\'s Closet',
            'Out of the Closet',
            'POP',
            'Pet Thrift Shop',
            'Rescue Mission (Ft Laud)',
            'Rescue Mission Thrift',
            'Salvation Army (Deltona)',
            'Salvation Army (Hialeah)',
            'Salvation Army (Kissimmee)',
            'Salvation Army (Lakeland)',
            'Salvation Army (Sanford)',
            'Salvation Army (Miami Beach)',
            'Salvation Army (Ft Laud)',
            'Salvation Army Thrift',
            'Second Harvest',
            'SHELL',
            'St. Vincent de Paul',
            'St. Vincent de Paul (Apopka)',
            'St. Vincent de Paul (Hialeah)',
            'St. Vincent de Paul (Orlando)',
            'St. Vincent de Paul (Sanford)',
            'St. Vincent de Paul (Miami Beach)',
            'St. Vincent de Paul (Ft Laud)',
            'Sunshine Thrift',
            'The HOPE Chest (Oviedo)',
            'THE NEIGHBORHOOD OF WEST VOLUSIA',
            'Thrift Boutique',
            'Thrift Mart',
            'Thrift Shop (Aventura)',
            'Thrift Shop (Coral Gables)',
            'Treasure Chest (Aventura)',
            'Treasure Chest (Coral Gables)',
            'Treasure Chest (Hollywood)',
            'Treasure Chest (Winter Haven)',
            'UCP Thrift Store',
            'Unity Thrift',
            'Victory Thrift',
            'West Volusia Habitat'
        ];

        try {
            $stores = $defaultStores;

            // 1. Fetch stores logged in local database logs
            try {
                $loggedStores = \App\Models\RecyclingLog::pluck('store')->toArray();
                foreach ($loggedStores as $s) {
                    if (!empty($s)) {
                        $stores[] = trim($s);
                    }
                }
            } catch (\Exception $dbEx1) {
                logger()->error('Error plucking stores from local logs: ' . $dbEx1->getMessage());
            }

            // 2. Fetch stores registered in local database custom stores table
            try {
                $dbStores = \App\Models\RecyclingStore::pluck('nombre')->toArray();
                foreach ($dbStores as $name) {
                    if (!empty($name)) {
                        $stores[] = trim($name);
                    }
                }
            } catch (\Exception $dbEx2) {
                logger()->error('Error plucking custom stores from local DB: ' . $dbEx2->getMessage());
            }

            $stores = array_unique($stores);
            $stores = array_values(array_filter($stores));
            usort($stores, 'strcasecmp');

            return response()->json([
                'success' => true,
                'stores' => $stores
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'stores' => $defaultStores,
                'warning' => 'Could not fetch stores from database: ' . $e->getMessage()
            ]);
        }
    }

    public function storeRecyclingLog(Request $request)
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'store' => 'required|string|max:255',
            'big' => 'required|integer|min:0',
            'small' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
        ]);

        try {
            // Save to Local Database
            \App\Models\RecyclingLog::create([
                'date' => $request->input('date'),
                'store' => $request->input('store'),
                'big' => $request->input('big'),
                'small' => $request->input('small'),
                'total' => $request->input('total'),
            ]);

            // Sync with Google Sheets
            try {
                $service = $this->getSheetsService();
                $spreadsheetId = $this->spreadsheetId;

                $row = [
                    $request->input('date'),
                    $request->input('store'),
                    $request->input('big'),
                    $request->input('small'),
                    $request->input('total')
                ];

                $range = 'recycling!A:E';
                $body = new ValueRange([
                    'values' => [$row]
                ]);

                $service->spreadsheets_values->append($spreadsheetId, $range, $body, [
                    'valueInputOption' => 'USER_ENTERED'
                ]);
            } catch (\Exception $sheetEx) {
                logger()->error('Failed to sync recycling log to Google Sheets: ' . $sheetEx->getMessage());
                return response()->json([
                    'success' => true,
                    'message' => '¡Registro guardado en base de datos local! (No se pudo sincronizar con Google Sheets temporalmente).'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Log added to local database and Google Sheets successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to log recycling data: ' . $e->getMessage()
            ], 500);
        }
    }

    // --- MÉTODOS DE RESERVAS (rooms-control) ---

    public function getBookings()
    {
        try {
            $service = $this->getSheetsService();
            $range = 'rooms!A2:K500';
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            $bookings = [];
            if (!empty($values)) {
                foreach ($values as $index => $row) {
                    $rowNum = $index + 2; // La fila en Google Sheets (A2 es índice 0 + 2)
                    $bookings[] = [
                        'row' => $rowNum,
                        'room' => $row[0] ?? '',
                        'cliente' => $row[1] ?? '',
                        'telefono' => $row[2] ?? '',
                        'fecha_inicio' => $row[3] ?? '',
                        'fecha_salida' => $row[4] ?? '',
                        'tasa_aseo' => $row[5] ?? '',
                        'deposito' => $row[6] ?? '',
                        'mensualidad' => $row[7] ?? '',
                        'estado' => $row[8] ?? '',
                        'notas' => $row[9] ?? '',
                        'fecha_registro' => $row[10] ?? '',
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener reservas: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createBooking(Request $request)
    {
        $request->validate([
            'room' => 'required',
            'cliente' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_salida' => 'required|date_format:Y-m-d',
            'tasa_aseo' => 'nullable|numeric',
            'deposito' => 'nullable|numeric',
            'mensualidad' => 'nullable|numeric',
            'estado' => 'required|string',
            'notas' => 'nullable|string'
        ]);

        try {
            $service = $this->getSheetsService();
            $row = [
                $request->input('room'),
                $request->input('cliente'),
                $request->input('telefono') ?? '',
                $request->input('fecha_inicio'),
                $request->input('fecha_salida'),
                $request->input('tasa_aseo') ?? 0,
                $request->input('deposito') ?? 0,
                $request->input('mensualidad') ?? 0,
                strtoupper($request->input('estado')),
                $request->input('notas') ?? '',
                date('Y-m-d H:i:s')
            ];

            $body = new ValueRange([
                'values' => [$row]
            ]);

            $service->spreadsheets_values->append($this->spreadsheetId, 'rooms!A:K', $body, [
                'valueInputOption' => 'USER_ENTERED'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva creada con éxito en Google Sheets.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateBooking(Request $request, $row)
    {
        $request->validate([
            'room' => 'required',
            'cliente' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date_format:Y-m-d',
            'fecha_salida' => 'required|date_format:Y-m-d',
            'tasa_aseo' => 'nullable|numeric',
            'deposito' => 'nullable|numeric',
            'mensualidad' => 'nullable|numeric',
            'estado' => 'required|string',
            'notas' => 'nullable|string',
            'fecha_registro' => 'nullable'
        ]);

        try {
            $service = $this->getSheetsService();
            $rowValues = [
                $request->input('room'),
                $request->input('cliente'),
                $request->input('telefono') ?? '',
                $request->input('fecha_inicio'),
                $request->input('fecha_salida'),
                $request->input('tasa_aseo') ?? 0,
                $request->input('deposito') ?? 0,
                $request->input('mensualidad') ?? 0,
                strtoupper($request->input('estado')),
                $request->input('notas') ?? '',
                $request->input('fecha_registro') ?? date('Y-m-d H:i:s')
            ];

            $body = new ValueRange([
                'values' => [$rowValues]
            ]);

            $service->spreadsheets_values->update($this->spreadsheetId, "rooms!A{$row}:K{$row}", $body, [
                'valueInputOption' => 'USER_ENTERED'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva actualizada con éxito en Google Sheets.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteBooking($row)
    {
        try {
            $service = $this->getSheetsService();
            $spreadsheet = $service->spreadsheets->get($this->spreadsheetId);
            $sheetId = null;

            foreach ($spreadsheet->getSheets() as $s) {
                if ($s->getProperties()->getTitle() === 'rooms') {
                    $sheetId = $s->getProperties()->getSheetId();
                    break;
                }
            }

            if ($sheetId === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró la pestaña rooms.'
                ], 404);
            }

            $requests = [
                new \Google\Service\Sheets\Request([
                    'deleteDimension' => [
                        'range' => [
                            'sheetId' => $sheetId,
                            'dimension' => 'ROWS',
                            'startIndex' => $row - 1, // 0-indexed, so row 2 is index 1
                            'endIndex' => $row
                        ]
                    ]
                ])
            ];

            $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);

            $service->spreadsheets->batchUpdate($this->spreadsheetId, $batchUpdateRequest);

            return response()->json([
                'success' => true,
                'message' => 'Reserva eliminada y fila eliminada con éxito.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkoutBooking($row)
    {
        try {
            $service = $this->getSheetsService();
            
            $body = new ValueRange([
                'values' => [['CERRADO']]
            ]);

            $service->spreadsheets_values->update($this->spreadsheetId, "rooms!I{$row}:I{$row}", $body, [
                'valueInputOption' => 'USER_ENTERED'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-out registrado con éxito (estado cerrado).'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al realizar check-out: ' . $e->getMessage()
            ], 500);
        }
    }
}

