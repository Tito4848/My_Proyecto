@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')

@section('content')

<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-shopping-bag me-2 text-primary"></i>Gestión de Pedidos</h1>
        <p class="text-muted mb-0">Administra todos los pedidos del restaurante</p>
    </div>
    <div>
        <a href="{{ route('admin.pedidos.create') }}" class="btn btn-modern btn-primary hover-glow">
            <i class="fas fa-plus me-2"></i>Nuevo Pedido
    </a>
    </div>
</div>

    <div class="admin-table animate-fade-in">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                    <th><i class="fas fa-user me-2"></i>Cliente</th>
                    <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                    <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                    <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                    <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pedidos as $pedido)
                    <tr class="animate-fade-in">
                        <td class="fw-bold">#{{ $pedido->id }}</td>
                        <td>
                            <i class="fas fa-user me-2 text-primary"></i>
                            {{ $pedido->nombre }}
                        </td>

                    <td>
                        @php
                            $colors = [
                                'pendiente'   => 'warning',
                                'preparando'  => 'info',
                                'encamino'    => 'primary',
                                'entregado'   => 'success',
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

                        <td class="fw-bold text-success">S/ {{ number_format($pedido->total, 2) }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>

                    <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.pedidos.show', $pedido) }}" 
                                   class="btn btn-sm btn-modern btn-primary hover-scale" 
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                        </a>

                                <a href="{{ route('admin.pedidos.edit', $pedido) }}" 
                                   class="btn btn-sm btn-modern btn-warning hover-scale"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.pedidos.destroy', $pedido) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este pedido?');">
                            @csrf
                            @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-modern btn-danger hover-scale"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                            </button>
                        </form>
                            </div>
                    </td>
                </tr>
            @empty
                <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">No hay pedidos registrados</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

</div>

@endsection
