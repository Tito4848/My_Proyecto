@extends('layouts.admin')

@section('title', 'Gestión de Reservas')

@section('content')

<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-calendar-check me-2 text-primary"></i>Gestión de Reservas</h1>
        <p class="text-muted mb-0">Administra todas las reservas del restaurante</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="admin-table animate-fade-in">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr>
                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                <th><i class="fas fa-user me-2"></i>Cliente</th>
                <th><i class="fas fa-chair me-2"></i>Mesa</th>
                <th><i class="fas fa-users me-2"></i>Personas</th>
                <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                <th><i class="fas fa-clock me-2"></i>Hora</th>
                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($reservas as $reserva)
                <tr class="animate-fade-in">
                    <td class="fw-bold">#{{ $reserva->id }}</td>
                    <td>
                        <i class="fas fa-user me-2 text-primary"></i>
                        {{ $reserva->nombre }}
                        @if($reserva->usuario)
                            <br><small class="text-muted">({{ $reserva->usuario->name }})</small>
                        @endif
                    </td>
                    <td>
                        @if($reserva->mesa)
                            <span class="badge bg-info">{{ $reserva->mesa->numero }}</span>
                        @else
                            <span class="text-muted">Sin mesa</span>
                        @endif
                    </td>
                    <td>{{ $reserva->personas }}</td>
                    <td>{{ $reserva->fecha->format('d/m/Y') }}</td>
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

                        <span class="badge bg-{{ $colors[$reserva->estado] ?? 'secondary' }} p-2">
                            <i class="fas fa-{{ $icons[$reserva->estado] ?? 'info' }} me-1"></i>
                            {{ ucfirst($reserva->estado) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('admin.reservas.show', $reserva) }}" 
                               class="btn btn-sm btn-modern btn-primary hover-scale" 
                               title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </a>

                            <form action="{{ route('admin.reservas.destroy', $reserva) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta reserva?');">
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
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p class="mb-0">No hay reservas registradas</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

