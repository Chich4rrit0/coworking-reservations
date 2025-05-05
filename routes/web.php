<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExportController;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas para salas (solo lectura para clientes)
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    
    // Rutas para salas (administración para administradores)
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    });
    
    // Esta ruta debe estar después de las rutas específicas para evitar conflictos
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    
    // Más rutas para salas (administración para administradores)
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    });
    
    // Rutas para reservaciones (clientes)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    
    // Rutas para administradores
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.update-status');
        // Mover la ruta de filtrado antes de la ruta de show para evitar conflictos
        Route::get('/reservations/filter', [ReservationController::class, 'filterByRoom'])->name('reservations.filter');
        Route::get('/export/reservations', [ExportController::class, 'exportReservations'])->name('export.reservations');
    });
    
    // Esta ruta debe estar después de las rutas específicas para evitar conflictos
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
});