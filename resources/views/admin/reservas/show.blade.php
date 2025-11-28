@extends('layouts.admin')

@section('title', 'Detalle de la Reserva')

@section('content')

<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-calendar-check me-2 text-primary"></i>Detalle de la Reserva #{{ $reserva->id }}</h1>
        <p class="text-muted mb-0">Fecha: {{ $reserva->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div>
        <a href="{{ route('admin.reservas.index') }}" class="btn btn-modern btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Información de la reserva -->
    <div class="col-md-8">
        <div class="modern-card p-4 animate-fade-in">
            <h4 class="mb-4 fw-bold">
                <i class="fas fa-user me-2 text-primary"></i>Datos del Cliente
            </h4>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Nombre</p>
                    <p class="fw-bold mb-0">{{ $reserva->nombre }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Email</p>
                    <p class="fw-bold mb-0">{{ $reserva->email ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Teléfono</p>
                    <p class="fw-bold mb-0">{{ $reserva->telefono }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Usuario</p>
                    <p class="fw-bold mb-0">
                        @if($reserva->usuario)
                            <i class="fas fa-user me-2"></i>{{ $reserva->usuario->name }}
                        @else
                            <span class="text-muted">No registrado</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Detalles de la reserva -->
        <div class="modern-card p-4 mt-4 animate-fade-in" style="animation-delay: 0.1s;">
            <h4 class="mb-4 fw-bold">
                <i class="fas fa-calendar-alt me-2 text-primary"></i>Detalles de la Reserva
            </h4>
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Mesa</p>
                    <p class="fw-bold mb-0">
                        @if($reserva->mesa)
                            <span class="badge bg-info fs-6">{{ $reserva->mesa->numero }}</span>
                            <small class="text-muted ms-2">(Capacidad: {{ $reserva->mesa->capacidad }} personas)</small>
                        @else
                            <span class="text-muted">Sin mesa asignada</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Personas</p>
                    <p class="fw-bold mb-0">{{ $reserva->personas }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Fecha</p>
                    <p class="fw-bold mb-0">{{ $reserva->fecha->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="mb-1 text-muted">Hora</p>
                    <p class="fw-bold mb-0">{{ $reserva->hora }}</p>
                </div>
            </div>
            @if($reserva->notas)
            <div class="mt-3 pt-3 border-top">
                <p class="mb-1 text-muted">Notas adicionales</p>
                <p class="fw-bold mb-0">{{ $reserva->notas }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Panel lateral -->
    <div class="col-md-4">
        <!-- Estado de la reserva -->
        <div class="modern-card p-4 animate-fade-in" style="animation-delay: 0.2s;">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-info-circle me-2 text-primary"></i>Estado de la Reserva
            </h5>
            
            @php
                $estadoColors = [
                    'pendiente' => 'warning',
                    'confirmada' => 'success',
                    'cancelada' => 'danger',
                    'completada' => 'secondary',
                ];
                $estadoIcons = [
                    'pendiente' => 'clock',
                    'confirmada' => 'check-circle',
                    'cancelada' => 'times-circle',
                    'completada' => 'check-double',
                ];
            @endphp

            <div class="mb-4">
                <span class="badge bg-{{ $estadoColors[$reserva->estado] ?? 'secondary' }} fs-6 p-3 w-100 d-block text-center mb-3">
                    <i class="fas fa-{{ $estadoIcons[$reserva->estado] ?? 'info' }} me-2"></i>
                    {{ ucfirst($reserva->estado) }}
                </span>
            </div>

            <form action="{{ route('admin.reservas.update', $reserva) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Cambiar Estado</label>
                    <select name="estado" class="modern-input form-select @error('estado') is-invalid @enderror">
                        <option value="pendiente" {{ $reserva->estado == 'pendiente' ? 'selected' : '' }}>
                            ⏰ Pendiente
                        </option>
                        <option value="confirmada" {{ $reserva->estado == 'confirmada' ? 'selected' : '' }}>
                            ✅ Confirmada
                        </option>
                        <option value="cancelada" {{ $reserva->estado == 'cancelada' ? 'selected' : '' }}>
                            ❌ Cancelada
                        </option>
                        <option value="completada" {{ $reserva->estado == 'completada' ? 'selected' : '' }}>
                            ✓ Completada
                        </option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Cambiar Mesa</label>
                    <select name="mesa_id" class="modern-input form-select @error('mesa_id') is-invalid @enderror">
                        <option value="">Sin mesa asignada</option>
                        @foreach($mesas as $mesa)
                            <option value="{{ $mesa->id }}" 
                                    {{ $reserva->mesa_id == $mesa->id ? 'selected' : '' }}
                                    data-capacidad="{{ $mesa->capacidad }}">
                                {{ $mesa->numero }} - {{ $mesa->capacidad }} personas
                                @if($mesa->ubicacion)
                                    ({{ $mesa->ubicacion }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('mesa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha</label>
                    <input type="date" 
                           name="fecha" 
                           value="{{ $reserva->fecha->format('Y-m-d') }}"
                           class="modern-input form-control @error('fecha') is-invalid @enderror"
                           min="{{ date('Y-m-d') }}">
                    @error('fecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Hora</label>
                    <input type="time" 
                           name="hora" 
                           value="{{ $reserva->hora }}"
                           class="modern-input form-control @error('hora') is-invalid @enderror">
                    @error('hora')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-modern btn-primary w-100 hover-glow">
                    <i class="fas fa-save me-2"></i>Actualizar Reserva
                </button>
            </form>
        </div>

        <!-- Acciones -->
        <div class="modern-card p-4 mt-4 animate-fade-in" style="animation-delay: 0.3s;">
            <h5 class="mb-4 fw-bold">
                <i class="fas fa-cog me-2 text-primary"></i>Acciones
            </h5>
            <div class="d-grid gap-2">
                <form action="{{ route('admin.reservas.destroy', $reserva) }}" 
                      method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar esta reserva?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-modern btn-danger w-100">
                        <i class="fas fa-trash me-2"></i>Eliminar Reserva
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
                <p class="mb-0 fw-bold">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($reserva->updated_at != $reserva->created_at)
            <div class="mb-2">
                <small class="text-muted">Última actualización:</small>
                <p class="mb-0 fw-bold">{{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

