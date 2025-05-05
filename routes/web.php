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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas para salas
    Route::resource('rooms', RoomController::class);
    
    // Rutas para reservaciones
    Route::resource('reservations', ReservationController::class)->except(['edit', 'update', 'destroy']);
    Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.update-status');
    Route::get('/reservations/filter', [ReservationController::class, 'filterByRoom'])->name('reservations.filter');
    
    // Rutas para administradores
    Route::middleware(['can:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/export/reservations', [ExportController::class, 'exportReservations'])->name('export.reservations');
    });
});