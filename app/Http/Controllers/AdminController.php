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
        
        // Estadísticas adicionales
        $pedidosPendientes = Pedido::where('estado', 'pendiente')->count();
        $pedidosEntregados = Pedido::where('estado', 'entregado')->count();
        $totalIngresos = Pedido::where('estado', 'entregado')->sum('total');
        $pedidosHoy = Pedido::whereDate('created_at', today())->count();
        
        // Pedidos recientes
        $pedidosRecientes = Pedido::with('usuario')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPlatos', 
            'totalPedidos', 
            'totalUsuarios',
            'pedidosPendientes',
            'pedidosEntregados',
            'totalIngresos',
            'pedidosHoy',
            'pedidosRecientes'
        ));
    }
}
