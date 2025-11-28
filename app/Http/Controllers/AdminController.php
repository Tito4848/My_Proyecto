<?php

namespace App\Http\Controllers;

use App\Models\Plato;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Reserva;

class AdminController extends Controller
{
    public function index()
    {
        $totalPlatos = Plato::count();
        $totalPedidos = Pedido::count();
        $totalUsuarios = User::count();
        $totalReservas = Reserva::count();
        
        // Estadísticas adicionales
        $pedidosPendientes = Pedido::where('estado', 'pendiente')->count();
        $pedidosEntregados = Pedido::where('estado', 'entregado')->count();
        $totalIngresos = Pedido::where('estado', 'entregado')->sum('total');
        $pedidosHoy = Pedido::whereDate('created_at', today())->count();
        
        // Estadísticas de reservas
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();
        $reservasConfirmadas = Reserva::where('estado', 'confirmada')->count();
        $reservasCanceladas = Reserva::where('estado', 'cancelada')->count();
        $reservasHoy = Reserva::whereDate('created_at', today())->count();
        
        // Pedidos recientes
        $pedidosRecientes = Pedido::with('usuario')->latest()->take(5)->get();
        
        // Reservas recientes
        $reservasRecientes = Reserva::with(['usuario', 'mesa'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPlatos', 
            'totalPedidos', 
            'totalUsuarios',
            'totalReservas',
            'pedidosPendientes',
            'pedidosEntregados',
            'totalIngresos',
            'pedidosHoy',
            'pedidosRecientes',
            'reservasPendientes',
            'reservasConfirmadas',
            'reservasCanceladas',
            'reservasHoy',
            'reservasRecientes'
        ));
    }
}
