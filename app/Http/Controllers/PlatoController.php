<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use Illuminate\Http\Request;

class PlatoController extends Controller
{
    public function index()
    {
        // Obtiene todos los platos de la base de datos
        $platos = Plato::all();

        // Los envía a la vista
        return view('platos.index', compact('platos'));
    }
}
