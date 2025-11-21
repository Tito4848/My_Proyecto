@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-chart-line me-2 text-primary"></i>Dashboard</h1>
        <p class="text-muted mb-0">Bienvenido al panel de administración</p>
    </div>
    <div>
        <span class="badge bg-primary">{{ now()->format('d/m/Y H:i') }}</span>
    </div>
</div>

<!-- Estadísticas principales -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary animate-scale-in">
            <div class="icon">
                <i class="fas fa-utensils"></i>
            </div>
            <h3 class="mb-1">{{ $totalPlatos }}</h3>
            <p class="text-muted mb-0">Total Platos</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card success animate-scale-in" style="animation-delay: 0.1s;">
            <div class="icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3 class="mb-1">{{ $totalPedidos }}</h3>
            <p class="text-muted mb-0">Total Pedidos</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card warning animate-scale-in" style="animation-delay: 0.2s;">
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="mb-1">{{ $totalUsuarios }}</h3>
            <p class="text-muted mb-0">Total Usuarios</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card info animate-scale-in" style="animation-delay: 0.3s;">
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <h3 class="mb-1">S/ {{ number_format($totalIngresos, 2) }}</h3>
            <p class="text-muted mb-0">Ingresos Totales</p>
        </div>
    </div>
</div>

<!-- Estadísticas de pedidos -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card danger animate-fade-in">
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <h3 class="mb-1">{{ $pedidosPendientes }}</h3>
            <p class="text-muted mb-0">Pedidos Pendientes</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card success animate-fade-in" style="animation-delay: 0.1s;">
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3 class="mb-1">{{ $pedidosEntregados }}</h3>
            <p class="text-muted mb-0">Pedidos Entregados</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card primary animate-fade-in" style="animation-delay: 0.2s;">
            <div class="icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <h3 class="mb-1">{{ $pedidosHoy }}</h3>
            <p class="text-muted mb-0">Pedidos de Hoy</p>
        </div>
    </div>
</div>

<!-- Accesos rápidos -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="modern-card p-4 text-center hover-lift">
            <i class="fas fa-utensils fa-3x text-primary mb-3"></i>
            <h5 class="mb-3">Gestionar Platos</h5>
            <p class="text-muted mb-3">Administra el menú del restaurante</p>
            <a href="{{ route('admin.platos.index') }}" class="btn btn-modern btn-primary w-100">
                <i class="fas fa-arrow-right me-2"></i>Ir a Platos
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="modern-card p-4 text-center hover-lift">
            <i class="fas fa-shopping-bag fa-3x text-success mb-3"></i>
            <h5 class="mb-3">Gestionar Pedidos</h5>
            <p class="text-muted mb-3">Revisa y administra los pedidos</p>
            <a href="{{ route('admin.pedidos.index') }}" class="btn btn-modern btn-success w-100">
                <i class="fas fa-arrow-right me-2"></i>Ir a Pedidos
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="modern-card p-4 text-center hover-lift">
            <i class="fas fa-users fa-3x text-warning mb-3"></i>
            <h5 class="mb-3">Gestionar Usuarios</h5>
            <p class="text-muted mb-3">Administra usuarios y permisos</p>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-modern btn-warning w-100">
                <i class="fas fa-arrow-right me-2"></i>Ir a Usuarios
            </a>
        </div>
    </div>
</div>

<!-- Pedidos recientes -->
@if($pedidosRecientes->count() > 0)
<div class="admin-table animate-fade-in">
    <div class="p-4 border-bottom">
        <h5 class="mb-0">
            <i class="fas fa-history me-2 text-primary"></i>Pedidos Recientes
        </h5>
    </div>
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidosRecientes as $pedido)
            <tr>
                <td>#{{ $pedido->id }}</td>
                <td>{{ $pedido->nombre }}</td>
                <td class="fw-bold text-success">S/ {{ number_format($pedido->total, 2) }}</td>
                <td>
                    @php
                        $colors = [
                            'pendiente' => 'warning',
                            'preparando' => 'info',
                            'encamino' => 'primary',
                            'entregado' => 'success',
                        ];
                    @endphp
                    <span class="badge bg-{{ $colors[$pedido->estado] ?? 'secondary' }}">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </td>
                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-sm btn-modern btn-primary">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection
