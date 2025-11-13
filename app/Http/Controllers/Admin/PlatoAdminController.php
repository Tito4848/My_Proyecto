<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plato;
use Illuminate\Http\Request;

class PlatoAdminController extends Controller
{
    public function index()
    {
        $platos = Plato::all();
        return view('admin.platos.index', compact('platos'));
    }

    public function create()
    {
        return view('admin.platos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
        ]);

        Plato::create($request->all());
        return redirect()->route('platos.index')->with('success', 'Plato creado');
    }

    public function edit(Plato $plato)
    {
        return view('admin.platos.edit', compact('plato'));
    }

    public function update(Request $request, Plato $plato)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
        ]);

        $plato->update($request->all());
        return redirect()->route('platos.index')->with('success', 'Plato actualizado');
    }

    public function destroy(Plato $plato)
    {
        $plato->delete();
        return redirect()->route('platos.index')->with('success', 'Plato eliminado');
    }
}
