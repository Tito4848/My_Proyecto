<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Plato;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('usuario')->latest()->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $platos = Plato::all();
        return view('admin.pedidos.create', compact('platos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required'],
            'direccion' => ['required'],
            'telefono' => ['required'],
            'metodo_pago' => ['required'],
            'estado' => ['required'],
            'plato_id.*' => ['required'],
            'cantidad.*' => ['required', 'numeric', 'min:1'],
        ]);

        // Crear pedido base
        $pedido = Pedido::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'metodo_pago' => $request->metodo_pago,
            'estado' => $request->estado,
            'total' => 0,
        ]);

        // Calcular total y guardar detalles
        $total = 0;

        foreach ($request->plato_id as $i => $platoId) {
            $plato = Plato::find($platoId);
            $cantidad = $request->cantidad[$i];
            $precio = $plato->precio * $cantidad;

            $total += $precio;

            $pedido->platos()->attach($platoId, [
                'cantidad' => $cantidad,
                'precio' => $plato->precio,
            ]);
        }

        // Actualizar el total final
        $pedido->update(['total' => $total]);

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido creado correctamente');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('platos');
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado' => ['required'],
        ]);

        $pedido->update([
            'estado' => $request->estado,
        ]);

        return redirect()
            ->route('admin.pedidos.index')
            ->with('success', 'Pedido actualizado correctamente');
    }
}
