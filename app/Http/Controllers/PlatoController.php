<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Http\Request;

class PlatoController extends Controller
{
    public function index()
    {
        // Obtener todos los platos
        $platos = Plato::all();

        // Enviar los platos a la vista
        return view('platos.index', compact('platos'));
    }
}
