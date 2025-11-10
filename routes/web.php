<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\CarritoController;

// ----------------------
// Carrito de compras
// ----------------------
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito');

// ----------------------
// Páginas principales
// ----------------------
Route::get('/', fn() => view('inicio'));
Route::get('/contacto', fn() => view('contacto'));
Route::get('/reserva', fn() => view('reserva'));

// ----------------------
// Platos
// ----------------------
Route::get('/platos', [PlatoController::class, 'index']);
Route::get('/menu', [App\Http\Controllers\PlatoController::class, 'index'])->name('menu');