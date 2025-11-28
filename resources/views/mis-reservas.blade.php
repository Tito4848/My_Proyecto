@extends('layouts.app')

@section('title', 'Mis Reservas | Sal & Sabor')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-gradient fw-bold mb-2" style="font-size: 2.5rem;">
                <i class="fas fa-calendar-check me-2"></i>Mis Reservas
            </h1>
            <p class="text-muted">Historial completo de todas tus reservas</p>
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if($reservas->isEmpty())
        <div class="row">
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
    @else
        <div class="row mb-4">
            <div class="col-12">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="filterReservas('all')">
                        <i class="fas fa-list me-1"></i>Todas
                    </button>
                    <button type="button" class="btn btn-outline-success" onclick="filterReservas('confirmada')">
                        <i class="fas fa-check me-1"></i>Confirmadas
                    </button>
                    <button type="button" class="btn btn-outline-warning" onclick="filterReservas('pendiente')">
                        <i class="fas fa-clock me-1"></i>Pendientes
                    </button>
                    <button type="button" class="btn btn-outline-danger" onclick="filterReservas('cancelada')">
                        <i class="fas fa-times me-1"></i>Canceladas
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="filterReservas('completada')">
                        <i class="fas fa-check-circle me-1"></i>Completadas
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="modern-card p-4 animate-fade-in">
                    <div class="table-responsive">
                        <table class="table-modern table table-hover">
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
                                @foreach ($reservas as $reserva)
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
    @endif
</div>

<style>
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
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
}

.hover-scale:hover {
    transform: scale(1.05);
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
</style>

<script>
function filterReservas(estado) {
    const rows = document.querySelectorAll('.reserva-row');
    const buttons = document.querySelectorAll('.btn-group button');
    
    // Actualizar botones activos
    buttons.forEach(btn => btn.classList.remove('active'));
    if (event && event.target) {
        event.target.classList.add('active');
    }
    
    // Filtrar filas
    rows.forEach(row => {
        if (estado === 'all' || row.dataset.estado === estado) {
            row.style.display = '';
            // Mostrar también la fila de detalles si está abierta
            const detalleId = 'reserva-detalle-' + row.dataset.reservaId || row.querySelector('[data-reserva-id]')?.dataset.reservaId;
            if (detalleId) {
                const detalle = document.getElementById(detalleId);
                if (detalle && detalle.style.display !== 'none') {
                    detalle.style.display = '';
                }
            }
        } else {
            row.style.display = 'none';
            // Ocultar también la fila de detalles
            const detalleId = 'reserva-detalle-' + (row.dataset.reservaId || row.id.split('-').pop());
            const detalle = document.getElementById(detalleId);
            if (detalle) {
                detalle.style.display = 'none';
            }
        }
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
</script>
@endsection

