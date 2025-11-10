<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', fn() => view('inicio'));
Route::get('/menu', fn() => view('menu'));
Route::get('/contacto', fn() => view('contacto'));
Route::get('/reserva', fn() => view('reserva'));

// Mostrar carrito
Route::get('/carrito', function () {
    $carrito = session('carrito', []);
    return view('carrito', compact('carrito'));
})->name('carrito');

// Agregar al carrito
Route::post('/carrito/agregar', function (Request $request) {
    $carrito = session('carrito', []);
    $id = $request->input('id');

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad']++;
    } else {
        $carrito[$id] = [
            'nombre' => $request->input('nombre'),
            'precio' => $request->input('precio'),
            'cantidad' => 1,
        ];
    }

    session(['carrito' => $carrito]);
    return redirect('/menu')->with('success', 'Producto agregado al carrito');
});

// Eliminar producto
Route::post('/carrito/eliminar', function (Request $request) {
    $carrito = session('carrito', []);
    $id = $request->input('id');
    unset($carrito[$id]);
    session(['carrito' => $carrito]);
    return redirect()->route('carrito');
});

// Vaciar carrito
Route::post('/carrito/vaciar', function () {
    session()->forget('carrito');
    return redirect()->route('carrito');
});

// Mostrar formulario de pago
Route::get('/pago', function () {
    $carrito = session('carrito', []);
    if (empty($carrito)) {
        return redirect()->route('carrito');
    }
    $total = array_reduce($carrito, fn($s, $i) => $s + ($i['precio'] * $i['cantidad']), 0);
    return view('pago', compact('total'));
})->name('pago');

// Procesar pago simulado
Route::post('/pago/procesar', function (Request $request) {
    session()->forget('carrito');
    return redirect('/')->with('success', 'Pago realizado correctamente. Gracias por tu compra.');
});
