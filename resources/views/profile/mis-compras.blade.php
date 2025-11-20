@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Compras</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id }}</td>
                    <td>S/ {{ $pedido->total }}</td>
                    <td>{{ $pedido->estado }}</td>
                    <td>{{ $pedido->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No tienes compras aún.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
