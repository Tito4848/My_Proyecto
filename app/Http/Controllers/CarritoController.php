<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function agregar(Request $request)
    {
        // Guardamos los productos en sesión
        $carrito = session()->get('carrito', []);

        $carrito[$request->id] = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => ($carrito[$request->id]['cantidad'] ?? 0) + 1,
        ];

        session(['carrito' => $carrito]);

        return redirect()->back()->with('success', "{$request->nombre} fue agregado al carrito.");
    }

    public function mostrar()
    {
        $carrito = session('carrito', []);
        return view('carrito.index', compact('carrito'));
    }
}
