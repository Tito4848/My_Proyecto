<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlatoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;

// Controladores Admin
use App\Http\Controllers\Admin\PlatoAdminController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->middleware(['auth', 'App\Http\Middleware\AdminMiddleware'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/usuarios/{id}/edit', [UserController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('admin.usuarios.update');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy');
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
Route::get('/pago', [CarritoController::class, 'continuarPago'])->name('pago');

// Contacto y reserva
Route::get('/contacto', function () { return view('contacto'); })->name('contacto');
Route::get('/reserva', function () { return view('reserva'); })->name('reserva');

// Delivery
Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery');
Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');

/*
|--------------------------------------------------------------------------
| Dashboard y perfil (requiere autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Panel de administración (requiere Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rutas con nombres para usar en blade
    Route::resource('/admin/platos', PlatoAdminController::class)->names('platos');
    Route::resource('/admin/pedidos', AdminPedidoController::class)->names('pedidos');
    Route::resource('/admin/usuarios', AdminUserController::class)->names('usuarios');
});


require __DIR__ . '/auth.php';
