@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('content')
<div class="container">
    <h2 class="text-center text-danger mb-4">Carrito de Compras</h2>

    @if(empty($carrito))
        <div class="alert alert-warning text-center">
            Tu carrito está vacío. Agrega productos desde el menú.
        </div>
        <div class="text-center">
            <a href="/menu" class="btn btn-outline-danger">Volver al Menú</a>
        </div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($carrito as $id => $item)
                    @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>S/ {{ number_format($item['precio'], 2) }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>S/ {{ number_format($subtotal, 2) }}</td>
                        <td class="text-center">
                            <form action="/carrito/eliminar" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button class="btn btn-outline-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-4">
            <h4 class="fw-bold">Total: S/ {{ number_format($total, 2) }}</h4>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <form action="/carrito/vaciar" method="POST">
                @csrf
                <button class="btn btn-outline-danger">Vaciar Carrito</button>
            </form>

            <a href="{{ route('pago') }}" class="btn btn-success">Continuar al Pago</a>
        </div>
    @endif
</div>
@endsection
