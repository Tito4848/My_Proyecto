<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('admin.pedidos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required',
            'total' => 'required|numeric',
            'estado' => 'required',
        ]);

        Pedido::create($request->all());
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado');
    }

    public function edit(Pedido $pedido)
    {
        return view('admin.pedidos.edit', compact('pedido'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'cliente' => 'required',
            'total' => 'required|numeric',
            'estado' => 'required',
        ]);

        $pedido->update($request->all());
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado');
    }
}
