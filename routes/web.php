<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\PedidoController;


// Controladores Admin
use App\Http\Controllers\Admin\PlatoAdminController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Panel de Administración (Correcto)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', AdminMiddleware::class])
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');

    Route::resource('platos', PlatoAdminController::class);
    Route::resource('pedidos', AdminPedidoController::class);
    Route::resource('usuarios', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::get('/menu', [PlatoController::class, 'index'])->name('menu');

// Carrito
Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito');
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('vaciar');


// Contacto y reserva
Route::get('/contacto', function () { return view('contacto'); })->name('contacto');
Route::get('/reserva', function () { return view('reserva'); })->name('reserva');

// Delivery
Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');
Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');

/*
|--------------------------------------------------------------------------
| Dashboard y perfil (usuarios normales)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/mis-compras', function () {
    $pedidos = \App\Models\Pedido::where('user_id', auth()->id())->get();
    return view('mis-compras', compact('pedidos'));
})->middleware('auth')->name('mis-compras');

Route::get('/perfil', [ProfileController::class, 'edit'])
    ->middleware(['auth'])
    ->name('perfil');
    Route::get('/pago', [PedidoController::class, 'pago'])
    ->middleware('auth')
    ->name('pago');

Route::post('/pago/procesar', [PedidoController::class, 'procesarPago'])
    ->middleware('auth')
    ->name('pago.procesar');


require __DIR__ . '/auth.php';
