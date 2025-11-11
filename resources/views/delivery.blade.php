@extends('layouts.app')

@section('title', 'Delivery | Sal & Sabor')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4 text-danger fw-bold">Delivery - ¡Llevamos el sabor a tu casa!</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $carrito = session('carrito', []);
    @endphp

    @if(count($carrito) > 0)
        <h3 class="mb-3">Tu carrito:</h3>
        <div class="row g-4 mb-4">
            @foreach($carrito as $item)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('images/' . $item['imagen']) }}" class="card-img-top" style="height:200px; object-fit:cover;" alt="{{ $item['nombre'] }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item['nombre'] }}</h5>
                            <p>Cantidad: {{ $item['cantidad'] }}</p>
                            <p class="fw-bold text-danger">S/. {{ number_format($item['precio'] * $item['cantidad'], 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="mb-3">Datos de entrega:</h3>
        <form action="{{ route('delivery.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección de entrega</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Número de contacto</label>
                <input type="text" name="telefono" id="telefono" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de pago</label>
                <select name="metodo_pago" id="metodo_pago" class="form-select" required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Enviar pedido</button>
        </form>
    @else
        <p class="text-center">No tienes productos en el carrito.</p>
    @endif
</div>
@endsection
