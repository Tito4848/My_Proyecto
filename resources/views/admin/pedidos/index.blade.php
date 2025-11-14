@extends('layouts.admin')

@section('title', 'Gestión de Pedidos')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Gestión de Pedidos</h2>

    <a href="{{ route('admin.pedidos.create') }}" class="btn btn-primary mb-3">
        + Nuevo Pedido
    </a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Cliente</th>
                <th>Estado</th>
                <th>Total</th>
                <th width="200px">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->nombre }}</td>

                    <td>
                        @php
                            $colors = [
                                'pendiente'   => 'warning',
                                'preparando'  => 'info',
                                'encamino'    => 'primary',
                                'entregado'   => 'success',
                            ];
                        @endphp

                        <span class="badge bg-{{ $colors[$pedido->estado] ?? 'secondary' }}">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </td>

                    <td>S/ {{ number_format($pedido->total, 2) }}</td>

                    <td>
                        <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-sm btn-secondary">
                            Ver
                        </a>

                        <a href="{{ route('admin.pedidos.edit', $pedido) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('admin.pedidos.destroy', $pedido) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar este pedido?')">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No hay pedidos registrados
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>

@endsection
