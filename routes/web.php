<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ReservaController;


// Controladores Admin
use App\Http\Controllers\Admin\PlatoAdminController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;

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
    Route::resource('reservas', AdminReservaController::class);
    
    // Tracking
    Route::post('/pedidos/{id}/actualizar-ubicacion', [\App\Http\Controllers\Admin\TrackingController::class, 'actualizarUbicacion'])->name('pedidos.actualizar-ubicacion');
    Route::post('/pedidos/{id}/simular-movimiento', [\App\Http\Controllers\Admin\TrackingController::class, 'simularMovimiento'])->name('pedidos.simular-movimiento');
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
Route::get('/sobre-nosotros', function () {
    return view('sobre-nosotros');
})->name('sobre-nosotros');

// Carrito (solo clientes autenticados)
Route::middleware(['auth', 'client_only'])->group(function () {
    Route::get('/carrito', [CarritoController::class, 'mostrar'])->name('carrito');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('vaciar');
});


// Contacto y reserva (reserva solo clientes)
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto');
Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');
Route::middleware(['client_only'])->group(function () {
    Route::get('/reserva', [ReservaController::class, 'index'])->name('reserva');
    Route::get('/reserva/mesas-disponibles', [ReservaController::class, 'obtenerMesasDisponibles'])->name('reserva.obtener-mesas');
    Route::get('/reserva/reserva-mesa', [ReservaController::class, 'obtenerReservaMesa'])->name('reserva.obtener-reserva-mesa');
    Route::post('/reserva', [ReservaController::class, 'store'])->name('reserva.store');
    Route::post('/reserva/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reserva.cancelar')->middleware('auth');
    Route::post('/reserva/{id}/cambiar-mesa', [ReservaController::class, 'cambiarMesa'])->name('reserva.cambiar-mesa')->middleware('auth');
}
);

// Delivery (solo clientes autenticados)
Route::middleware(['auth', 'client_only'])->group(function () {
    Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');
    Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');
});

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
    $pedidos = \App\Models\Pedido::where('user_id', auth()->id())
        ->with('platos')
        ->orderBy('created_at', 'desc')
        ->get();
    return view('mis-compras', compact('pedidos'));
})->middleware(['auth', 'client_only'])->name('mis-compras');

Route::get('/mis-reservas', function () {
    $reservas = \App\Models\Reserva::where('user_id', auth()->id())
        ->with('mesa')
        ->orderBy('created_at', 'desc')
        ->get();
    return view('mis-reservas', compact('reservas'));
})->middleware(['auth', 'client_only'])->name('mis-reservas');

Route::get('/perfil', [ProfileController::class, 'edit'])
    ->middleware(['auth'])
    ->name('perfil');
    Route::get('/pago', [PedidoController::class, 'pago'])
    ->middleware(['auth', 'client_only'])
    ->name('pago');

Route::post('/pago/procesar', [PedidoController::class, 'procesarPago'])
    ->middleware(['auth', 'client_only'])
    ->name('pago.procesar');

Route::get('/menu/{plato}', [PlatoController::class, 'show'])->name('menu.show');

Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
Route::get('/seguimiento/{codigo}', [PedidoController::class, 'seguimiento'])->name('seguimiento');
Route::get('/pedidos/{id}/estado', [PedidoController::class, 'obtenerEstado'])->name('pedidos.estado');
Route::post('/pedidos/{id}/actualizar-estado', [PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizar-estado')->middleware('auth');
Route::post('/pedidos/{id}/actualizar-ubicacion', [PedidoController::class, 'actualizarUbicacion'])->name('pedidos.actualizar-ubicacion')->middleware('auth');

require __DIR__ . '/auth.php';
