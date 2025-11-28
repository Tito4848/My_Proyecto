@extends('layouts.app')

@section('title', 'Mi Perfil | Sal & Sabor')

@section('content')
<div class="container py-5">
    <!-- Header del Perfil -->
    <div class="row mb-5 animate-fade-in">
        <div class="col-12">
            <div class="modern-card p-5 text-center">
                <div class="position-relative d-inline-block mb-4">
                    <div class="avatar-container">
                        @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 class="avatar-image"
                                 id="avatarPreview">
                        @else
                            <div class="avatar-placeholder" id="avatarPreview">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                        @endif
                        <div class="avatar-overlay">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                </div>
                <h1 class="text-gradient fw-bold mb-2" style="font-size: 2.5rem;">
                    {{ $user->name }}
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                </p>
                @if($user->is_admin)
                    <span class="badge bg-danger mt-2">
                        <i class="fas fa-crown me-1"></i>Administrador
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if(session('status') === 'profile-updated')
        <x-alert type="success">Perfil actualizado correctamente.</x-alert>
    @endif

    <div class="row g-4">
        <!-- Información del Perfil -->
        <div class="col-lg-8">
            <div class="modern-card p-4 mb-4 animate-fade-in">
                <h3 class="mb-4 fw-bold">
                    <i class="fas fa-user-edit me-2 text-primary"></i>Información del Perfil
                </h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Cambiar Contraseña -->
            <div class="modern-card p-4 mb-4 animate-fade-in" style="animation-delay: 0.1s;">
                <h3 class="mb-4 fw-bold">
                    <i class="fas fa-lock me-2 text-primary"></i>Cambiar Contraseña
                </h3>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Estadísticas -->
            <div class="modern-card p-4 mb-4 animate-fade-in" style="animation-delay: 0.2s;">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Mis Estadísticas
                </h5>
                @php
                    $totalPedidos = $pedidos->count();
                    $completados = $pedidos->where('estado', 'entregado')->count();
                    $pendientes = $pedidos->where('estado', 'pendiente')->count();
                    $preparando = $pedidos->where('estado', 'preparando')->count();
                    $enCamino = $pedidos->where('estado', 'encamino')->count();
                    $totalGastado = $pedidos->where('estado', 'entregado')->sum('total');
                    $promedioPedido = $totalPedidos > 0 ? $pedidos->avg('total') : 0;
                    
                    $totalReservas = $reservas->count();
                    $reservasConfirmadas = $reservas->where('estado', 'confirmada')->count();
                    $reservasPendientes = $reservas->where('estado', 'pendiente')->count();
                    $reservasCanceladas = $reservas->where('estado', 'cancelada')->count();
                    $reservasCompletadas = $reservas->where('estado', 'completada')->count();
                @endphp
                
                <div class="stat-card mb-3 p-3 rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center text-white">
                        <div>
                            <small class="opacity-75">Total Gastado</small>
                            <h4 class="mb-0 fw-bold">S/ {{ number_format($totalGastado, 2) }}</h4>
                        </div>
                        <i class="fas fa-wallet fa-2x opacity-50"></i>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-shopping-bag me-2 text-primary"></i>Pedidos Totales
                    </span>
                    <span class="fw-bold fs-5 text-primary">{{ $totalPedidos }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-check-circle me-2 text-success"></i>Completados
                    </span>
                    <span class="fw-bold fs-5 text-success">{{ $completados }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-clock me-2 text-warning"></i>Pendientes
                    </span>
                    <span class="fw-bold fs-5 text-warning">{{ $pendientes }}</span>
                </div>
                @if($preparando > 0)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-utensils me-2 text-info"></i>En Preparación
                    </span>
                    <span class="fw-bold fs-5 text-info">{{ $preparando }}</span>
                </div>
                @endif
                @if($enCamino > 0)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-truck me-2 text-primary"></i>En Camino
                    </span>
                    <span class="fw-bold fs-5 text-primary">{{ $enCamino }}</span>
                </div>
                @endif
                @if($totalPedidos > 0)
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-chart-line me-1"></i>Promedio por pedido
                    </small>
                    <span class="fw-bold text-primary">S/ {{ number_format($promedioPedido, 2) }}</span>
                </div>
                @endif
            </div>

            <!-- Estadísticas de Reservas -->
            <div class="modern-card p-4 mb-4 animate-fade-in" style="animation-delay: 0.25s;">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-calendar-check me-2 text-warning"></i>Mis Reservas
                </h5>
                
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-calendar me-2 text-warning"></i>Total Reservas
                    </span>
                    <span class="fw-bold fs-5 text-warning">{{ $totalReservas }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-check-circle me-2 text-success"></i>Confirmadas
                    </span>
                    <span class="fw-bold fs-5 text-success">{{ $reservasConfirmadas }}</span>
                </div>
                @if($reservasPendientes > 0)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-clock me-2 text-warning"></i>Pendientes
                    </span>
                    <span class="fw-bold fs-5 text-warning">{{ $reservasPendientes }}</span>
                </div>
                @endif
                @if($reservasCanceladas > 0)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-times-circle me-2 text-danger"></i>Canceladas
                    </span>
                    <span class="fw-bold fs-5 text-danger">{{ $reservasCanceladas }}</span>
                </div>
                @endif
                @if($reservasCompletadas > 0)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded hover-lift" style="background: #f8f9fa;">
                    <span class="text-muted">
                        <i class="fas fa-check-double me-2 text-secondary"></i>Completadas
                    </span>
                    <span class="fw-bold fs-5 text-secondary">{{ $reservasCompletadas }}</span>
                </div>
                @endif
            </div>

            <!-- Acciones Rápidas -->
            <div class="modern-card p-4 mb-4 animate-fade-in" style="animation-delay: 0.3s;">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-bolt me-2 text-primary"></i>Acciones Rápidas
                </h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                        <i class="fas fa-utensils me-2"></i>Ver Menú
                    </a>
                    <a href="{{ route('carrito') }}" class="btn btn-modern btn-success hover-lift">
                        <i class="fas fa-shopping-cart me-2"></i>Mi Carrito
                    </a>
                    <a href="{{ route('mis-compras') }}" class="btn btn-modern btn-info hover-lift">
                        <i class="fas fa-history me-2"></i>Mis Compras
                    </a>
                    <a href="{{ route('mis-reservas') }}" class="btn btn-modern btn-warning hover-lift">
                        <i class="fas fa-calendar-check me-2"></i>Mis Reservas
                    </a>
                    <a href="{{ route('reserva') }}" class="btn btn-modern btn-success hover-lift">
                        <i class="fas fa-calendar-alt me-2"></i>Hacer Reserva
                    </a>
                    <a href="{{ route('contacto') }}" class="btn btn-modern btn-secondary hover-lift">
                        <i class="fas fa-envelope me-2"></i>Contacto
                    </a>
                </div>
            </div>
            
            <!-- Información de Cuenta -->
            <div class="modern-card p-4 animate-fade-in" style="animation-delay: 0.4s;">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Información de Cuenta
                </h5>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-calendar-plus me-1"></i>Miembro desde
                    </small>
                    <span class="fw-bold">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">
                        <i class="fas fa-envelope-check me-1"></i>Email verificado
                    </small>
                    @if($user->email_verified_at)
                        <span class="badge bg-success">
                            <i class="fas fa-check me-1"></i>Verificado
                        </span>
                    @else
                        <span class="badge bg-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>Pendiente
                        </span>
                    @endif
                </div>
                @if($user->is_admin)
                <div class="mt-3 pt-3 border-top">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-danger w-100">
                        <i class="fas fa-crown me-2"></i>Panel de Administración
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Mis Pedidos -->
    @if($pedidos->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-4 animate-fade-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0 fw-bold">
                        <i class="fas fa-receipt me-2 text-primary"></i>Historial de Pedidos
                    </h3>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" onclick="filterPedidos('all')">
                            <i class="fas fa-list me-1"></i>Todos
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="filterPedidos('pendiente')">
                            <i class="fas fa-clock me-1"></i>Pendientes
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="filterPedidos('entregado')">
                            <i class="fas fa-check me-1"></i>Completados
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table-modern table table-hover" id="pedidosTable">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                                <th><i class="fas fa-map-marker-alt me-2"></i>Dirección</th>
                                <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            <tr class="pedido-row" data-estado="{{ $pedido->estado }}">
                                <td class="fw-bold">#{{ $pedido->id }}</td>
                                <td class="fw-bold text-success">S/ {{ number_format($pedido->total, 2) }}</td>
                                <td>
                                    @php
                                        $colors = [
                                            'pendiente' => 'warning',
                                            'preparando' => 'info',
                                            'encamino' => 'primary',
                                            'entregado' => 'success',
                                        ];
                                        $icons = [
                                            'pendiente' => 'clock',
                                            'preparando' => 'utensils',
                                            'encamino' => 'truck',
                                            'entregado' => 'check-circle',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$pedido->estado] ?? 'secondary' }} px-3 py-2">
                                        <i class="fas fa-{{ $icons[$pedido->estado] ?? 'info' }} me-1"></i>
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div>{{ $pedido->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($pedido->direccion ?? 'N/A', 30) }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-modern btn-primary hover-scale" 
                                                onclick="toggleCarrito({{ $pedido->id }})"
                                                title="Ver detalles">
                                            <i class="fas fa-eye me-1"></i> Detalles
                                        </button>
                                        @if($pedido->codigo_seguimiento)
                                        <a href="{{ route('seguimiento', $pedido->codigo_seguimiento) }}" 
                                           class="btn btn-sm btn-modern btn-success hover-scale"
                                           title="Seguimiento en tiempo real">
                                            <i class="fas fa-truck me-1"></i> Seguimiento
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr id="carrito-{{ $pedido->id }}" style="display:none;" class="table-light">
                                <td colspan="5">
                                    <div class="p-4">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-list-ul me-2"></i>Detalles del Pedido #{{ $pedido->id }}
                                        </h6>
                                        @php
                                            $items = [];
                                            // Primero intentar obtener de la relación platos
                                            if($pedido->platos && $pedido->platos->count() > 0) {
                                                foreach($pedido->platos as $plato) {
                                                    $items[] = [
                                                        'nombre' => $plato->nombre,
                                                        'cantidad' => $plato->pivot->cantidad ?? 1,
                                                        'precio' => $plato->pivot->precio ?? $plato->precio,
                                                        'subtotal' => ($plato->pivot->cantidad ?? 1) * ($plato->pivot->precio ?? $plato->precio),
                                                    ];
                                                }
                                            } 
                                            // Si no hay platos, intentar obtener del carrito JSON
                                            elseif($pedido->carrito) {
                                                $carritoData = is_string($pedido->carrito) ? json_decode($pedido->carrito, true) : $pedido->carrito;
                                                if(is_array($carritoData) && count($carritoData) > 0) {
                                                    foreach($carritoData as $item) {
                                                        if(isset($item['nombre']) || isset($item['id'])) {
                                                            $items[] = [
                                                                'nombre' => $item['nombre'] ?? 'Producto',
                                                                'cantidad' => $item['cantidad'] ?? 1,
                                                                'precio' => $item['precio'] ?? 0,
                                                                'subtotal' => ($item['cantidad'] ?? 1) * ($item['precio'] ?? 0),
                                                            ];
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        
                                        @if(count($items) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm table-bordered mb-3">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th><i class="fas fa-utensils me-1"></i>Producto</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-end">Precio Unit.</th>
                                                            <th class="text-end">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($items as $item)
                                                            <tr>
                                                                <td><strong>{{ $item['nombre'] ?? 'N/A' }}</strong></td>
                                                                <td class="text-center">{{ $item['cantidad'] ?? 0 }}</td>
                                                                <td class="text-end">S/ {{ number_format($item['precio'] ?? 0, 2) }}</td>
                                                                <td class="text-end fw-bold">S/ {{ number_format($item['subtotal'] ?? 0, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <th colspan="3" class="text-end">Total del Pedido:</th>
                                                            <th class="text-end text-success fs-5">S/ {{ number_format($pedido->total, 2) }}</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong><i class="fas fa-user me-2"></i>Cliente:</strong> {{ $pedido->nombre ?? $user->name }}</p>
                                                    <p class="mb-1"><strong><i class="fas fa-phone me-2"></i>Teléfono:</strong> {{ $pedido->telefono ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong><i class="fas fa-map-marker-alt me-2"></i>Dirección:</strong> {{ $pedido->direccion ?? 'N/A' }}</p>
                                                    <p class="mb-1"><strong><i class="fas fa-credit-card me-2"></i>Método de Pago:</strong> {{ $pedido->metodo_pago ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-warning mb-0">
                                                <i class="fas fa-exclamation-triangle me-2"></i>No se encontraron detalles para este pedido.
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-5 text-center animate-fade-in">
                <div class="mb-4">
                    <i class="fas fa-shopping-bag fa-5x text-muted mb-3" style="opacity: 0.3;"></i>
                </div>
                <h4 class="fw-bold mb-2">No tienes pedidos registrados</h4>
                <p class="text-muted mb-4">Comienza a explorar nuestro delicioso menú y realiza tu primer pedido</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                        <i class="fas fa-utensils me-2"></i>Ver Menú
                    </a>
                    <a href="{{ route('reserva') }}" class="btn btn-modern btn-success hover-lift">
                        <i class="fas fa-calendar-alt me-2"></i>Hacer Reserva
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Mis Reservas -->
    @if($reservas->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-4 animate-fade-in">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0 fw-bold">
                        <i class="fas fa-calendar-check me-2 text-primary"></i>Historial de Reservas
                    </h3>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary active" onclick="filterReservas('all')">
                            <i class="fas fa-list me-1"></i>Todas
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="filterReservas('confirmada')">
                            <i class="fas fa-check me-1"></i>Confirmadas
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="filterReservas('cancelada')">
                            <i class="fas fa-times me-1"></i>Canceladas
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="filterReservas('completada')">
                            <i class="fas fa-check-circle me-1"></i>Completadas
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table-modern table table-hover" id="reservasTable">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-chair me-2"></i>Mesa</th>
                                <th><i class="fas fa-users me-2"></i>Personas</th>
                                <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                                <th><i class="fas fa-clock me-2"></i>Hora</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $reserva)
                            <tr class="reserva-row" data-estado="{{ $reserva->estado }}">
                                <td class="fw-bold">#{{ $reserva->id }}</td>
                                <td>
                                    @if($reserva->mesa)
                                        <span class="badge bg-info">{{ $reserva->mesa->numero }}</span>
                                        <small class="text-muted d-block">{{ $reserva->mesa->capacidad }} personas</small>
                                    @else
                                        <span class="text-muted">Sin mesa asignada</span>
                                    @endif
                                </td>
                                <td class="fw-bold">{{ $reserva->personas }}</td>
                                <td>
                                    <div>{{ $reserva->fecha->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $reserva->created_at->format('H:i') }}</small>
                                </td>
                                <td>{{ $reserva->hora }}</td>
                                <td>
                                    @php
                                        $colors = [
                                            'pendiente' => 'warning',
                                            'confirmada' => 'success',
                                            'cancelada' => 'danger',
                                            'completada' => 'secondary',
                                        ];
                                        $icons = [
                                            'pendiente' => 'clock',
                                            'confirmada' => 'check-circle',
                                            'cancelada' => 'times-circle',
                                            'completada' => 'check-double',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$reserva->estado] ?? 'secondary' }} px-3 py-2">
                                        <i class="fas fa-{{ $icons[$reserva->estado] ?? 'info' }} me-1"></i>
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-modern btn-primary hover-scale" 
                                                onclick="toggleReservaDetalle({{ $reserva->id }})"
                                                title="Ver detalles">
                                            <i class="fas fa-eye me-1"></i> Detalles
                                        </button>
                                        @if(in_array($reserva->estado, ['pendiente', 'confirmada']))
                                        <form action="{{ route('reserva.cancelar', $reserva->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de cancelar esta reserva?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-modern btn-danger hover-scale" title="Cancelar reserva">
                                                <i class="fas fa-times me-1"></i> Cancelar
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr id="reserva-detalle-{{ $reserva->id }}" style="display:none;" class="table-light">
                                <td colspan="7">
                                    <div class="p-4">
                                        <h6 class="fw-bold mb-3 text-primary">
                                            <i class="fas fa-info-circle me-2"></i>Detalles de la Reserva #{{ $reserva->id }}
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong><i class="fas fa-user me-2"></i>Nombre:</strong> {{ $reserva->nombre }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-envelope me-2"></i>Email:</strong> {{ $reserva->email ?? 'N/A' }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-phone me-2"></i>Teléfono:</strong> {{ $reserva->telefono }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong><i class="fas fa-chair me-2"></i>Mesa:</strong> {{ $reserva->mesa ? $reserva->mesa->numero . ' (' . $reserva->mesa->capacidad . ' personas)' : 'Sin mesa asignada' }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-calendar me-2"></i>Fecha:</strong> {{ $reserva->fecha->format('d/m/Y') }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-clock me-2"></i>Hora:</strong> {{ $reserva->hora }}</p>
                                                <p class="mb-2"><strong><i class="fas fa-users me-2"></i>Personas:</strong> {{ $reserva->personas }}</p>
                                            </div>
                                        </div>
                                        @if($reserva->notas)
                                        <div class="mt-3 pt-3 border-top">
                                            <p class="mb-1"><strong><i class="fas fa-sticky-note me-2"></i>Notas:</strong></p>
                                            <p class="text-muted">{{ $reserva->notas }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-5 text-center animate-fade-in">
                <div class="mb-4">
                    <i class="fas fa-calendar-times fa-5x text-muted mb-3" style="opacity: 0.3;"></i>
                </div>
                <h4 class="fw-bold mb-2">No tienes reservas registradas</h4>
                <p class="text-muted mb-4">Reserva una mesa para disfrutar de nuestra deliciosa comida</p>
                <a href="{{ route('reserva') }}" class="btn btn-modern btn-primary hover-lift">
                    <i class="fas fa-calendar-alt me-2"></i>Hacer Reserva
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Eliminar Cuenta -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-4 border-danger animate-fade-in">
                <h5 class="mb-4 fw-bold text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Zona de Peligro
                </h5>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
.avatar-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.avatar-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #d62828;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.avatar-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 4px solid #d62828;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.avatar-overlay {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 45px;
    height: 45px;
    background: #d62828;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 3px solid white;
    box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}

.avatar-container:hover .avatar-overlay {
    transform: scale(1.1);
    background: #b71f1f;
}

.avatar-container:hover .avatar-image,
.avatar-container:hover .avatar-placeholder {
    transform: scale(1.05);
}

.modern-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.modern-card:hover {
    box-shadow: 0 5px 25px rgba(0,0,0,0.12);
    transform: translateY(-2px);
}

.btn-modern {
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}

.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.hover-scale:hover {
    transform: scale(1.05);
}

.hover-glow:hover {
    box-shadow: 0 0 20px rgba(214, 40, 40, 0.4);
}

.text-gradient {
    background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.table-modern {
    border-collapse: separate;
    border-spacing: 0;
}

.table-modern thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    padding: 15px;
    border: none;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
}

.table-modern tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
}

.table-modern tbody td {
    padding: 15px;
    vertical-align: middle;
    border-top: 1px solid #e9ecef;
}

.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.badge {
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
}

.modern-input {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.modern-input:focus {
    border-color: #d62828;
    box-shadow: 0 0 0 0.2rem rgba(214, 40, 40, 0.25);
    outline: none;
}

@media (max-width: 768px) {
    .avatar-image, .avatar-placeholder {
        width: 120px;
        height: 120px;
    }
    
    .table-responsive {
        font-size: 0.9rem;
    }
}
</style>

<script>
function toggleCarrito(id) {
    const row = document.getElementById("carrito-" + id);
    const isVisible = row.style.display !== "none";
    
    // Cerrar todos los demás detalles
    document.querySelectorAll('[id^="carrito-"]').forEach(function(el) {
        if (el.id !== "carrito-" + id) {
            el.style.display = "none";
        }
    });
    
    // Toggle del actual
    row.style.display = isVisible ? "none" : "";
    
    // Scroll suave al elemento si se está abriendo
    if (!isVisible) {
        setTimeout(() => {
            row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }
}

function filterPedidos(estado) {
    const rows = document.querySelectorAll('.pedido-row');
    const buttons = document.querySelectorAll('#pedidosTable').length > 0 ? 
        document.querySelectorAll('#pedidosTable').closest('.modern-card').querySelectorAll('.btn-group button') : [];
    
    // Actualizar botones activos
    buttons.forEach(btn => btn.classList.remove('active'));
    if (event && event.target) {
        event.target.classList.add('active');
    }
    
    // Filtrar filas
    rows.forEach(row => {
        if (estado === 'all' || row.dataset.estado === estado) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Ocultar detalles abiertos
    document.querySelectorAll('[id^="carrito-"]').forEach(el => {
        el.style.display = "none";
    });
}

function filterReservas(estado) {
    const rows = document.querySelectorAll('.reserva-row');
    const buttons = document.querySelectorAll('#reservasTable').length > 0 ? 
        document.querySelectorAll('#reservasTable').closest('.modern-card').querySelectorAll('.btn-group button') : [];
    
    // Actualizar botones activos
    buttons.forEach(btn => btn.classList.remove('active'));
    if (event && event.target) {
        event.target.classList.add('active');
    }
    
    // Filtrar filas
    rows.forEach(row => {
        if (estado === 'all' || row.dataset.estado === estado) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Ocultar detalles abiertos
    document.querySelectorAll('[id^="reserva-detalle-"]').forEach(el => {
        el.style.display = "none";
    });
}

function toggleReservaDetalle(id) {
    const row = document.getElementById("reserva-detalle-" + id);
    const isVisible = row.style.display !== "none";
    
    // Cerrar todos los demás detalles
    document.querySelectorAll('[id^="reserva-detalle-"]').forEach(function(el) {
        if (el.id !== "reserva-detalle-" + id) {
            el.style.display = "none";
        }
    });
    
    // Toggle del actual
    row.style.display = isVisible ? "none" : "";
    
    // Scroll suave al elemento si se está abriendo
    if (!isVisible) {
        setTimeout(() => {
            row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }
}

// Preview de avatar antes de subir
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tamaño (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La imagen es demasiado grande. Por favor, selecciona una imagen menor a 2MB.');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatarPreview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        preview.outerHTML = `<img src="${e.target.result}" alt="Preview" class="avatar-image" id="avatarPreview">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Animaciones de entrada
    const cards = document.querySelectorAll('.animate-fade-in');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection
