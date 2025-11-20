<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    public function pago()
    {
        // Validar carrito vacío
        if (!session('carrito') || count(session('carrito')) === 0) {
            return redirect()->route('carrito.index')->with('error', 'Tu carrito está vacío');
        }

        // Calcular total
        $total = 0;
        foreach (session('carrito') as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('pago', compact('total'));
    }

    public function procesarPago(Request $request)
    {
        
        // GUARDA EL PEDIDO
        Pedido::create([
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            'direccion' => 'Pago con tarjeta',
            'telefono' => '000',
            'metodo_pago' => 'Tarjeta',
            'carrito' => json_encode(session('carrito')),
            'total' => $this->calcularTotal(),
            'estado' => 'pendiente',
        ]);

        // Limpiar carrito
        session()->forget('carrito');

        // Mandar al perfil del usuario
        return redirect()->route('profile.edit')
                         ->with('success', 'Pago realizado y pedido registrado correctamente');
    }

    private function calcularTotal()
    {
        $total = 0;
        foreach (session('carrito') as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        return $total;
    }
    
}
