<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeliveryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de inicio
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Menú de platos
Route::get('/menu', [PlatoController::class, 'index'])->name('menu');

// Carrito
Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('vaciar');
Route::get('/pago', [CarritoController::class, 'continuarPago'])->name('pago');

// Contacto y reserva
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::get('/reserva', function () {
    return view('reserva');
})->name('reserva');

// Delivery
Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');
Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');

// Dashboard y perfil (requiere autenticación)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
