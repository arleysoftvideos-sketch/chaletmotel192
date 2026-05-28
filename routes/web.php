<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GoogleSheetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::post('/api/sync-room', [GoogleSheetController::class, 'syncRoom'])->name('api.sync-room');
Route::get('/api/load-room/{room}', [GoogleSheetController::class, 'loadRoom'])->name('api.load-room');

Route::get('/test', function () {
    return 'hola mundogit';
});

Route::get('/test-json', function () {
    $path = storage_path('app/google-credentials.json');
    $exists = file_exists($path);
    $readable = is_readable($path);
    $content = @file_get_contents($path);
    $decoded = json_decode($content, true);
    
    $sheets_connection = 'No probado';
    $sheets_error = null;
    $spreadsheet_title = null;
    
    if ($exists && $readable && !is_null($decoded)) {
        try {
            $client = new \Google\Client();
            $client->setAuthConfig($path);
            $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
            $service = new \Google\Service\Sheets($client);
            
            $spreadsheet = $service->spreadsheets->get('1_HLh9a0v70MrRMd2ZGQy9j_v41HeNI-1i8xqsyd9RXE');
            $spreadsheet_title = $spreadsheet->getProperties()->getTitle();
            $sheets_connection = 'Exitosa';
        } catch (\Exception $e) {
            $sheets_connection = 'Fallida';
            $sheets_error = $e->getMessage();
        }
    }
    
    return response()->json([
        'path' => $path,
        'exists' => $exists,
        'readable' => $readable,
        'size_bytes' => $content !== false ? strlen($content) : null,
        'decoded_valid' => !is_null($decoded),
        'client_email' => $decoded['client_email'] ?? 'Not found',
        'json_error' => json_last_error_msg(),
        'sheets_api_connection' => $sheets_connection,
        'sheets_api_error' => $sheets_error,
        'spreadsheet_title' => $spreadsheet_title
    ]);
});

// Rutas Públicas de Contacto
Route::get('/contactar', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contactar', [ContactController::class, 'store'])->name('contact.store');

// Ruta de Inventario
Route::get('/inventario', function () {
    return view('inventario');
})->name('inventario');

// Rutas Públicas de Habitaciones
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de Reservas para Clientes Autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rooms/{room}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
});

// Rutas de Administración (Protegidas por auth y middleware de admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('rooms', RoomController::class)->except(['index', 'show']);
    Route::post('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.status');
});

require __DIR__.'/auth.php';
