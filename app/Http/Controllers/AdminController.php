<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use App\Models\Pedido;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalPlatos = Plato::count();
        $totalPedidos = Pedido::count();
        $totalUsuarios = User::count();

        return view('admin.dashboard', compact('totalPlatos', 'totalPedidos', 'totalUsuarios'));
    }
}
