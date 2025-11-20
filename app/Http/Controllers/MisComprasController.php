<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MisComprasController extends Controller
{
    public function index()
    {
        // Obtener pedidos del usuario actual
        $pedidos = Auth::user()
            ->pedidos()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.mis-compras', compact('pedidos'));
    }
}
