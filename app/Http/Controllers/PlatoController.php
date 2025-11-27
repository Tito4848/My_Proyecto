<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Http\Request;

class PlatoController extends Controller
{
    public function index()
    {
        // Obtener todos los platos desde la base de datos
        $platos = Plato::all();

        // Enviar los platos a la vista 'menu.blade.php'
        return view('menu', compact('platos'));
    }

    public function show(Plato $plato)
    {
        return view('menu.show', compact('plato'));
    }
}
