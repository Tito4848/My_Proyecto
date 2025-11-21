@extends('layouts.admin')

@section('title', 'Editar Pedido')

@section('content')

<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-edit me-2 text-primary"></i>Editar Pedido #{{ $pedido->id }}</h1>
        <p class="text-muted mb-0">Modifica la información del pedido</p>
    </div>
    <div>
        <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-modern btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <div class="modern-card p-4 animate-fade-in">

        <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="mb-3">Datos del Cliente</h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $pedido->nombre) }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                           value="{{ old('direccion', $pedido->direccion) }}" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono', $pedido->telefono) }}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Método de Pago</label>
                    <select name="metodo_pago" class="form-control @error('metodo_pago') is-invalid @enderror" required>
                        <option value="Efectivo" {{ old('metodo_pago', $pedido->metodo_pago) == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="Tarjeta" {{ old('metodo_pago', $pedido->metodo_pago) == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="Yape"    {{ old('metodo_pago', $pedido->metodo_pago) == 'Yape' ? 'selected' : '' }}>Yape</option>
                        <option value="Plin"    {{ old('metodo_pago', $pedido->metodo_pago) == 'Plin' ? 'selected' : '' }}>Plin</option>
                    </select>
                    @error('metodo_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Estado</label>
                    <select name="estado" class="form-control @error('estado') is-invalid @enderror" required>
                        <option value="pendiente"  {{ old('estado', $pedido->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="preparando" {{ old('estado', $pedido->estado) == 'preparando' ? 'selected' : '' }}>En preparación</option>
                        <option value="encamino"   {{ old('estado', $pedido->estado) == 'encamino' ? 'selected' : '' }}>En camino</option>
                        <option value="entregado"  {{ old('estado', $pedido->estado) == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a href="{{ route('admin.pedidos.show', $pedido) }}" class="btn btn-modern btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-modern btn-primary hover-glow">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
