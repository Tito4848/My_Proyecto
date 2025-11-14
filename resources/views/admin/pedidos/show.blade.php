@extends('layouts.admin')

@section('title', 'Detalle del Pedido')

@section('content')

<style>
    .ticket-container {
        max-width: 600px;
        margin: auto;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        font-size: 15px;
    }

    .ticket-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .ticket-header h2 {
        margin: 0;
        font-size: 22px;
    }

    .ticket-section {
        margin-bottom: 20px;
    }

    .ticket-section h4 {
        font-size: 16px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 6px;
        margin-bottom: 12px;
    }

    .ticket-items table {
        width: 100%;
    }

    .ticket-items th, .ticket-items td {
        padding: 8px;
        border-bottom: 1px solid #eee;
    }

    .ticket-footer {
        text-align: right;
        font-size: 18px;
        font-weight: bold;
    }

    .btn-print {
        width: 100%;
    }
</style>

<div class="ticket-container">

    <div class="ticket-header">
        <h2>Detalle del Pedido #{{ $pedido->id }}</h2>
        <small>{{ $pedido->created_at->format('d/m/Y H:i') }}</small>
    </div>

    <div class="ticket-section">
        <h4>Datos del Cliente</h4>
        <p><strong>Nombre:</strong> {{ $pedido->nombre }}</p>
        <p><strong>Dirección:</strong> {{ $pedido->direccion }}</p>
        <p><strong>Teléfono:</strong> {{ $pedido->telefono }}</p>
        <p><strong>Método de pago:</strong> {{ $pedido->metodo_pago }}</p>
    </div>

    <div class="ticket-section">
        <h4>Estado</h4>
        <form action="{{ route('admin.pedidos.update', $pedido) }}" method="POST">
            @csrf
            @method('PUT')

            <select name="estado" class="form-control mb-3">
                <option value="pendiente"     {{ $pedido->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="preparando"    {{ $pedido->estado == 'preparando' ? 'selected' : '' }}>En preparación</option>
                <option value="encamino"      {{ $pedido->estado == 'encamino' ? 'selected' : '' }}>En camino</option>
                <option value="entregado"     {{ $pedido->estado == 'entregado' ? 'selected' : '' }}>Entregado</option>
            </select>

            <button class="btn btn-primary w-100">Actualizar Estado</button>
        </form>
    </div>

    <div class="ticket-section ticket-items">
        <h4>Platos</h4>

        <table>
            <thead>
                <tr>
                    <th>Plato</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pedido->platos as $plato)
                    <tr>
                        <td>{{ $plato->nombre }}</td>
                        <td>{{ $plato->pivot->cantidad }}</td>
                        <td>S/ {{ number_format($plato->pivot->precio, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div class="ticket-footer">
        Total: S/ {{ number_format($pedido->total, 2) }}
    </div>

    <button class="btn btn-secondary mt-3 btn-print" onclick="window.print()">Imprimir recibo</button>

</div>

@endsection
