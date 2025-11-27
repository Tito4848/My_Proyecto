@extends('layouts.admin')

@section('title', 'Detalle del Pedido')

@section('content')

<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-receipt me-2 text-primary"></i>Detalle del Pedido #{{ $pedido->id }}</h1>
        <p class="text-muted mb-0">Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div>
        <a href="{{ route('admin.pedidos.index') }}" class="btn btn-modern btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Información del pedido -->
    <div class="col-md-8">
        <div class="modern-card p-4 animate-fade-in">
            <h4 class="mb-4 fw-bold">
                <i class="fas fa-user me-2 text-primary"></i>Datos del Cliente
            </h4>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Nombre</p>
                    <p class="fw-bold mb-0">{{ $pedido->nombre }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Teléfono</p>
                    <p class="fw-bold mb-0">{{ $pedido->telefono }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Dirección</p>
                    <p class="fw-bold mb-0">{{ $pedido->direccion }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Método de pago</p>
                    <p class="fw-bold mb-0">
                        <i class="fas fa-credit-card me-2"></i>{{ $pedido->metodo_pago }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Platos del pedido -->
        <div class="modern-card p-4 mt-4 animate-fade-in" style="animation-delay: 0.1s;">
            <h4 class="mb-4 fw-bold">
                <i class="fas fa-utensils me-2 text-primary"></i>Platos del Pedido
            </h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Plato</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $items = [];
                            // Primero intentar obtener desde la relación platos
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
                                // Manejar tanto string JSON como array (el modelo tiene cast 'array' pero puede fallar)
                                if(is_string($pedido->carrito)) {
                                    $carritoData = json_decode($pedido->carrito, true);
                                    // Si json_decode falla, intentar como array directamente
                                    if(json_last_error() !== JSON_ERROR_NONE) {
                                        $carritoData = null;
                                    }
                                } else {
                                    $carritoData = $pedido->carrito;
                                }
                                
                                // Procesar el carrito si es un array válido
                                if(is_array($carritoData) && count($carritoData) > 0) {
                                    // Convertir array asociativo (con IDs como claves) a array indexado
                                    $carritoArray = array_values($carritoData);
                                    
                                    foreach($carritoArray as $item) {
                                        // Verificar que el item sea un array con los datos necesarios
                                        if(is_array($item) && (isset($item['nombre']) || isset($item['id']))) {
                                            $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
                                            $precio = isset($item['precio']) ? (float)$item['precio'] : 0;
                                            $items[] = [
                                                'nombre' => $item['nombre'] ?? 'Producto',
                                                'cantidad' => $cantidad,
                                                'precio' => $precio,
                                                'subtotal' => $cantidad * $precio,
                                            ];
                                        }
                                    }
                                }
                            }
                        @endphp

                        @forelse($items as $item)
                            <tr>
                                <td class="fw-semibold">
                                    <i class="fas fa-utensils me-2 text-primary"></i>
                                    {{ $item['nombre'] ?? 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge-modern bg-primary text-white">
                                        {{ $item['cantidad'] ?? 0 }}
                                    </span>
                                </td>
                                <td class="text-end">S/ {{ number_format($item['precio'] ?? 0, 2) }}</td>
                                <td class="text-end fw-bold text-success">
                                    S/ {{ number_format($item['subtotal'] ?? (($item['cantidad'] ?? 0) * ($item['precio'] ?? 0)), 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p class="mb-0">No hay platos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-end text-danger fs-5">S/ {{ number_format($pedido->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Panel lateral -->
    <div class="col-md-4">
        <!-- Estado del pedido -->
        <div class="modern-card p-4 animate-fade-in" style="animation-delay: 0.2s;">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-info-circle me-2 text-primary"></i>Estado del Pedido
            </h5>
            
            @php
                $estadoColors = [
                    'pendiente' => 'warning',
                    'preparando' => 'info',
                    'encamino' => 'primary',
                    'entregado' => 'success',
                ];
                $estadoIcons = [
                    'pendiente' => 'clock',
                    'preparando' => 'utensils',
                    'encamino' => 'truck',
                    'entregado' => 'check-circle',
                ];
            @endphp

            <div class="mb-4">
                <span class="badge bg-{{ $estadoColors[$pedido->estado] ?? 'secondary' }} fs-6 p-3 w-100 d-block text-center mb-3">
                    <i class="fas fa-{{ $estadoIcons[$pedido->estado] ?? 'info' }} me-2"></i>
                    {{ ucfirst($pedido->estado) }}
                </span>
            </div>

            <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Cambiar Estado</label>
                    <select name="estado" class="modern-input form-select @error('estado') is-invalid @enderror">
                        <option value="pendiente" {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>
                            ⏰ Pendiente
                        </option>
                        <option value="preparando" {{ $pedido->estado == 'preparando' ? 'selected' : '' }}>
                            🍳 En preparación
                        </option>
                        <option value="encamino" {{ $pedido->estado == 'encamino' ? 'selected' : '' }}>
                            🚚 En camino
                        </option>
                        <option value="entregado" {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>
                            ✅ Entregado
                        </option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-modern btn-primary w-100 hover-glow">
                    <i class="fas fa-save me-2"></i>Actualizar Estado
                </button>
            </form>
        </div>

        <!-- Rastreo en Tiempo Real -->
        @if($pedido->codigo_seguimiento)
        <div class="modern-card p-4 mt-4 animate-fade-in" style="animation-delay: 0.3s;">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-map-marked-alt me-2 text-primary"></i>Rastreo del Pedido
            </h5>
            
            @if($pedido->latitud && $pedido->longitud)
            <div class="mb-3">
                <small class="text-muted d-block mb-1">Ubicación Actual:</small>
                <p class="mb-0 fw-bold">
                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                    Lat: {{ number_format($pedido->latitud, 6) }}, Lng: {{ number_format($pedido->longitud, 6) }}
                </p>
            </div>
            @endif
            
            <div class="d-grid gap-2">
                <a href="{{ route('seguimiento', $pedido->codigo_seguimiento) }}" 
                   target="_blank"
                   class="btn btn-modern btn-info">
                    <i class="fas fa-eye me-2"></i>Ver Rastreo en Tiempo Real
                </a>
                <button onclick="simularMovimiento({{ $pedido->id }})" 
                        class="btn btn-modern btn-warning">
                    <i class="fas fa-sync me-2"></i>Simular Movimiento
                </button>
            </div>
            
            @if($pedido->ultima_actualizacion_ubicacion)
            <div class="mt-3 pt-3 border-top">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Última actualización: {{ $pedido->ultima_actualizacion_ubicacion->diffForHumans() }}
                </small>
            </div>
            @endif
        </div>
        @endif

        <!-- Acciones -->
        <div class="modern-card p-4 mt-4 animate-fade-in" style="animation-delay: 0.4s;">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-cog me-2 text-primary"></i>Acciones
            </h5>
            <div class="d-grid gap-2">
                <button onclick="window.print()" class="btn btn-modern btn-secondary">
                    <i class="fas fa-print me-2"></i>Imprimir Recibo
                </button>
                <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="btn btn-modern btn-warning">
                    <i class="fas fa-edit me-2"></i>Editar Pedido
                </a>
                <form action="{{ route('admin.pedidos.destroy', $pedido) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar este pedido?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-modern btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Eliminar Pedido
                    </button>
                </form>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="modern-card p-4 mt-4 animate-fade-in" style="animation-delay: 0.4s;">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-calendar me-2 text-primary"></i>Información
            </h5>
            <div class="mb-2">
                <small class="text-muted">Fecha de creación:</small>
                <p class="mb-0 fw-bold">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($pedido->updated_at != $pedido->created_at)
            <div class="mb-2">
                <small class="text-muted">Última actualización:</small>
                <p class="mb-0 fw-bold">{{ $pedido->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @endif
            @if($pedido->usuario)
            <div>
                <small class="text-muted">Usuario:</small>
                <p class="mb-0 fw-bold">
                    <i class="fas fa-user me-2"></i>{{ $pedido->usuario->name }}
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function simularMovimiento(pedidoId) {
    if (!confirm('¿Deseas simular el movimiento del pedido? Esto actualizará su ubicación.')) {
        return;
    }
    
    fetch(`/admin/pedidos/${pedidoId}/simular-movimiento`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Ubicación actualizada correctamente. El cliente verá el cambio en tiempo real.');
            location.reload();
        } else {
            alert('Error: ' + (data.error || 'No se pudo actualizar la ubicación'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al simular el movimiento');
    });
}
</script>

<style>
    @media print {
        .admin-header,
        .col-md-4,
        .btn {
            display: none !important;
        }
        .col-md-8 {
            width: 100% !important;
        }
    }
</style>

@endsection
