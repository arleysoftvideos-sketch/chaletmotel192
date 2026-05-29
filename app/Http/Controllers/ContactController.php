<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

use App\Models\Contact;

class ContactController extends Controller
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

    public function create()
    {
        return view('contactar');
    }

    public function store(Request $request)
    {
        // 1. Protección contra Bots (Honeypot)
        if ($request->filled('website_url')) {
            // Si el campo invisible está lleno, es un bot. Lo ignoramos y fingimos éxito.
            return redirect()->back()->with('success', 'Estamos tramitando su solicitud, en un momento nos pondremos en contacto.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:25',
            'message' => 'required|string|min:5',
        ]);

        // 2. Protección contra Inyección JavaScript/XSS
        $validated['name'] = strip_tags($validated['name']);
        $validated['email'] = strip_tags($validated['email']);
        $validated['phone'] = strip_tags($validated['phone'] ?? '');
        $validated['message'] = strip_tags($validated['message']);

        // Guardar localmente en la base de datos
        Contact::create($validated);

        // 2. Sincronizar con Google Sheets en la pestaña 'contact'
        try {
            $service = $this->getSheetsService();
            
            $rowValues = [
                $validated['name'],
                $validated['email'],
                $validated['phone'] ?? '',
                $validated['message']
            ];

            // Apendamos el registro en la pestaña 'contact', columnas A-D
            $range = 'contact!A:D';
            $body = new ValueRange([
                'values' => [$rowValues]
            ]);

            $service->spreadsheets_values->append($this->spreadsheetId, $range, $body, [
                'valueInputOption' => 'USER_ENTERED'
            ]);
        } catch (\Exception $e) {
            // Guardamos el error en los logs pero permitimos que la web continúe
            logger()->error('Error al guardar contacto en Google Sheets: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Estamos tramitando su solicitud, en un momento nos pondremos en contacto.');
    }
}
