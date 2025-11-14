<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class DeliveryController extends Controller
{
    // Mostrar la vista de delivery con los productos del carrito
    public function index()
    {
        $carrito = session('carrito', []);
        return view('delivery', compact('carrito'));
    }

    // Guardar el pedido en la base de datos
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'metodo_pago' => 'required|string',
        ]);

        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('delivery')->with('error', 'El carrito está vacío.');
        }

        // Guardamos el pedido
        Pedido::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'metodo_pago' => $request->metodo_pago,
            'carrito' => json_encode(array_values($carrito)),
        ]);

        // Limpiamos el carrito
        session()->forget('carrito');

        return redirect()->route('delivery')->with('success', '¡Pedido recibido y guardado correctamente!');
    }
}
