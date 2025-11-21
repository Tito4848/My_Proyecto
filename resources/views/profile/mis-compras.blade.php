@extends('layouts.app')

@section('title', 'Mis Compras | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-gradient fw-bold animate-fade-in" style="font-size: 3rem;">
        <i class="fas fa-history me-3"></i>Mis Compras
    </h1>
    
    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if(session('info'))
        <x-alert type="info">{{ session('info') }}</x-alert>
    @endif

    @if($pedidos->count() > 0)
        <div class="admin-table animate-fade-in">
            <table class="table table-hover mb-0">
                <thead class="table-light">
            <tr>
                        <th><i class="fas fa-hashtag me-2"></i>ID Pedido</th>
                        <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                        <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                        <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                        <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
            </tr>
        </thead>
        <tbody>
                    @foreach($pedidos as $pedido)
                        <tr class="animate-fade-in">
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
                                <span class="badge bg-{{ $colors[$pedido->estado] ?? 'secondary' }} p-2">
                                    <i class="fas fa-{{ $icons[$pedido->estado] ?? 'info' }} me-1"></i>
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-modern btn-primary hover-scale" 
                                        onclick="toggleDetalles({{ $pedido->id }})"
                                        title="Ver detalles">
                                    <i class="fas fa-eye"></i> Detalles
                                </button>
                            </td>
                </tr>
                        <tr id="detalles-{{ $pedido->id }}" style="display:none;" class="table-light">
                            <td colspan="5">
                                <div class="p-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="fas fa-utensils me-2 text-primary"></i>Detalles del Pedido:
                                    </h6>
                                    @php
                                        $items = [];
                                        if($pedido->platos && $pedido->platos->count() > 0) {
                                            foreach($pedido->platos as $plato) {
                                                $items[] = [
                                                    'nombre' => $plato->nombre,
                                                    'cantidad' => $plato->pivot->cantidad,
                                                    'precio' => $plato->pivot->precio,
                                                ];
                                            }
                                        } elseif($pedido->carrito && is_array($pedido->carrito)) {
                                            $items = $pedido->carrito;
                                        }
                                    @endphp
                                    <div class="row g-3">
                                        @foreach($items as $item)
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded">
                                                    <div>
                                                        <i class="fas fa-utensils me-2 text-primary"></i>
                                                        <strong>{{ $item['nombre'] ?? 'N/A' }}</strong>
                                                    </div>
                                                    <div class="text-end">
                                                        <small class="text-muted">Cant: {{ $item['cantidad'] ?? 0 }}</small><br>
                                                        <span class="fw-bold text-success">S/ {{ number_format(($item['cantidad'] ?? 0) * ($item['precio'] ?? 0), 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Total del Pedido:</h6>
                                            <h5 class="mb-0 text-danger fw-bold">S/ {{ number_format($pedido->total, 2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </td>
                </tr>
                    @endforeach
        </tbody>
    </table>
</div>
    @else
        <div class="text-center animate-fade-in">
            <div class="modern-card p-5" style="max-width: 500px; margin: 0 auto;">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">No tienes compras aún</h4>
                <p class="text-muted mb-4">Realiza tu primer pedido y aparecerá aquí</p>
                <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                    <i class="fas fa-utensils me-2"></i>Ver Menú
                </a>
            </div>
        </div>
    @endif
</div>

<script>
function toggleDetalles(id) {
    const row = document.getElementById("detalles-" + id);
    row.style.display = row.style.display === "none" ? "" : "none";
}
</script>
@endsection
