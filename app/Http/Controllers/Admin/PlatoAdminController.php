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
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName(); // nombre seguro
            $file->move(public_path('images'), $filename); // guardar en /public/images
        }

        Plato::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $filename, // solo el nombre
        ]);

        return redirect()->route('admin.platos.index')
                         ->with('success', 'Plato creado correctamente.');
    }

    public function edit(Plato $plato)
    {
        return view('admin.platos.edit', compact('plato'));
    }

    public function update(Request $request, Plato $plato)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {

            // Borrar imagen anterior si existe
            if ($plato->imagen && file_exists(public_path('images/' . $plato->imagen))) {
                unlink(public_path('images/' . $plato->imagen));
            }

            // Guardar la nueva
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $plato->imagen = $filename;
        }

        // Actualiza datos del plato
        $plato->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('admin.platos.index')
                         ->with('success', 'Plato actualizado correctamente.');
    }

    public function destroy(Plato $plato)
    {
        // Borrar imagen asociada
        if ($plato->imagen && file_exists(public_path('images/' . $plato->imagen))) {
            unlink(public_path('images/' . $plato->imagen));
        }

        $plato->delete();

        return redirect()->route('admin.platos.index')
                         ->with('success', 'Plato eliminado correctamente.');
    }
}
