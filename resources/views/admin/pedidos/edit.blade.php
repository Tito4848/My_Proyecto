@extends('layouts.admin')

@section('title', 'Editar Pedido')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Editar Pedido #{{ $pedido->id }}</h2>

    <div class="card p-4">

        <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="mb-3">Datos del Cliente</h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                           value="{{ $pedido->nombre }}" required>
                </div>

                <div class="col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control"
                           value="{{ $pedido->direccion }}" required>
                </div>

                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control"
                           value="{{ $pedido->telefono }}" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Método de Pago</label>
                    <select name="metodo_pago" class="form-control" required>
                        <option value="Efectivo" {{ $pedido->metodo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="Tarjeta" {{ $pedido->metodo_pago == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="Yape"    {{ $pedido->metodo_pago == 'Yape' ? 'selected' : '' }}>Yape</option>
                        <option value="Plin"    {{ $pedido->metodo_pago == 'Plin' ? 'selected' : '' }}>Plin</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="pendiente"  {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="preparando" {{ $pedido->estado == 'preparando' ? 'selected' : '' }}>En preparación</option>
                        <option value="encamino"   {{ $pedido->estado == 'encamino' ? 'selected' : '' }}>En camino</option>
                        <option value="entregado"  {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                </div>
            </div>

            <hr>

            <div class="text-end">
                <button class="btn btn-primary">Guardar Cambios</button>
            </div>

        </form>
    </div>
</div>

@endsection
