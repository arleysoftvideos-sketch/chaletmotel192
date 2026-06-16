<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GoogleSheetController;
use App\Http\Controllers\RecyclingController;
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

Route::get('/learning-center', function () {
    return view('learning_center');
})->name('learning_center');

Route::get('/social-networks', function () {
    return view('social_networks');
})->name('social.networks');

Route::post('/api/sync-room', [GoogleSheetController::class, 'syncRoom'])->name('api.sync-room');
Route::get('/api/load-room/{room}', [GoogleSheetController::class, 'loadRoom'])->name('api.load-room');
Route::get('/api/load-all-rooms', [GoogleSheetController::class, 'loadAllRooms'])->name('api.load-all-rooms');


// Rutas Públicas de Contacto
Route::get('/contactar', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contactar', [ContactController::class, 'store'])->name('contact.store');
Route::post('/api/chat-contact', [ContactController::class, 'storeFromChatbot'])->name('contact.chatbot');

// Ruta de Inventario
Route::get('/inventario', function () {
    return view('inventario');
})->name('inventario');

// Ruta de Control de Habitaciones
Route::get('/rooms-control', function () {
    return view('rooms_control');
})->name('rooms.control');

// Rutas de API para Control de Habitaciones (Reservaciones en Google Sheets)
Route::get('/api/rooms-control/bookings', [GoogleSheetController::class, 'getBookings'])->name('api.rooms-control.bookings');
Route::post('/api/rooms-control/bookings', [GoogleSheetController::class, 'createBooking'])->name('api.rooms-control.create-booking');
Route::put('/api/rooms-control/bookings/{row}', [GoogleSheetController::class, 'updateBooking'])->name('api.rooms-control.update-booking');
Route::delete('/api/rooms-control/bookings/{row}', [GoogleSheetController::class, 'deleteBooking'])->name('api.rooms-control.delete-booking');
Route::post('/api/rooms-control/bookings/{row}/checkout', [GoogleSheetController::class, 'checkoutBooking'])->name('api.rooms-control.checkout');


// Ruta de Reciclaje
Route::get('/recycling', [RecyclingController::class, 'index'])->name('recycling');
Route::post('/recycling/save', [RecyclingController::class, 'saveToSheets'])->name('recycling.save');

Route::get('/api/recycling/stores', [GoogleSheetController::class, 'getRecyclingStores'])->name('api.recycling.stores');
Route::post('/api/recycling/log', [GoogleSheetController::class, 'storeRecyclingLog'])->name('api.recycling.log');
Route::get('/api/recycling/stats', [RecyclingController::class, 'getStats'])->name('api.recycling.stats');
Route::get('/sync-recycling-data', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('recycling:sync-from-sheets');
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'success' => true,
            'message' => 'Sincronización exitosa con Google Sheets.',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al sincronizar: ' . $e->getMessage()
        ], 500);
    }
});

Route::get('/run-migrations', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();
        return response()->json([
            'success' => true,
            'message' => 'Migraciones ejecutadas exitosamente.',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al ejecutar migraciones: ' . $e->getMessage()
        ], 500);
    }
});

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
