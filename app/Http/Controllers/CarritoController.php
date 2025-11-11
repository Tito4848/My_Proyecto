<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plato;

class CarritoController extends Controller
{
    // Agregar plato al carrito
    public function agregar(Request $request)
    {
        $plato = Plato::find($request->id);
        if(!$plato){
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        $cantidad = $request->cantidad ?? 1;

        $carrito = session()->get('carrito', []);

        if(isset($carrito[$plato->id])){
            $carrito[$plato->id]['cantidad'] += $cantidad;
        } else {
            $carrito[$plato->id] = [
                'id' => $plato->id,
                'nombre' => $plato->nombre,
                'precio' => $plato->precio,
                'imagen' => $plato->imagen,
                'cantidad' => $cantidad,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    // Mostrar carrito
    public function mostrar()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    // Eliminar un plato del carrito
    public function eliminar($id)
    {
        $carrito = session()->get('carrito', []);

        if(isset($carrito[$id])){
            unset($carrito[$id]);
            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito.');
    }

    // Vaciar carrito
    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito')->with('success', 'El carrito ha sido vaciado.');
    }

    // Continuar a pago
    public function continuarPago()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;

        foreach($carrito as $item){
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('pago', compact('carrito', 'total'));
    }
}
