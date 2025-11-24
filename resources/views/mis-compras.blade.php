@extends('layouts.app')

@section('title', 'Mis Compras | Sal & Sabor')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-gradient fw-bold mb-2" style="font-size: 2.5rem;">
                <i class="fas fa-shopping-bag me-2"></i>Mis Compras
            </h1>
            <p class="text-muted">Historial completo de todos tus pedidos</p>
        </div>
    </div>

    @if($pedidos->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="modern-card p-5 text-center animate-fade-in">
                    <div class="mb-4">
                        <i class="fas fa-shopping-bag fa-5x text-muted mb-3" style="opacity: 0.3;"></i>
                    </div>
                    <h4 class="fw-bold mb-2">No tienes compras registradas</h4>
                    <p class="text-muted mb-4">Comienza a explorar nuestro delicioso menú y realiza tu primer pedido</p>
                    <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                        <i class="fas fa-utensils me-2"></i>Ver Menú
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="modern-card p-4 animate-fade-in">
                    <div class="table-responsive">
                        <table class="table-modern table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                    <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                                    <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                                    <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                    <th><i class="fas fa-map-marker-alt me-2"></i>Dirección</th>
                                    <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pedidos as $pedido)
                                <tr>
                                    <td class="fw-bold">#{{ $pedido->id }}</td>
                                    <td>
                                        <div>{{ $pedido->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $pedido->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="fw-bold text-success">S/ {{ number_format($pedido->total ?? 0, 2) }}</td>
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
                                        <small class="text-muted">
                                            {{ Str::limit($pedido->direccion ?? 'N/A', 30) }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-modern btn-primary hover-scale">
                                            <i class="fas fa-eye me-1"></i> Ver Detalles
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
