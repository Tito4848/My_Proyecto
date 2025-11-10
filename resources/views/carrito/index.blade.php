@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Tu Carrito</h1>

    @if(empty($carrito))
        <p class="text-center">Tu carrito está vacío.</p>
    @else
        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio (S/)</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ number_format($item['precio'], 2) }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="text-center mt-4">
        <a href="{{ url('/platos') }}" class="btn btn-secondary">Seguir comprando</a>
    </div>
</div>
@endsection
