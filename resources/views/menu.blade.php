@extends('layouts.app')

@section('title', 'Menú | Sal & Sabor')

@section('content')
<h1 class="text-center mb-4">Nuestro Menú</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">

    @php
        $productos = [
            ['id' => 1, 'nombre' => 'Pollo a la Brasa', 'precio' => 25, 'img' => 'https://www.eatperu.com/wp-content/uploads/2019/10/pollo-a-la-brasa-with-salad-and-dipping-sauces.jpg'],
            ['id' => 2, 'nombre' => 'Lomo Saltado', 'precio' => 30, 'img' => 'https://assets.afcdn.com/recipe/20210416/119490_w3072h2304c1cx363cy240.jpg'],
            ['id' => 3, 'nombre' => 'Ceviche Clásico', 'precio' => 28, 'img' => 'https://i.pinimg.com/originals/71/ca/eb/71caeb0ebe4d90ec278ebb26cdcac1df.png']
        ];
    @endphp

    @foreach($productos as $producto)
    <div class="col-md-4">
        <div class="card h-100">
            <img src="{{ $producto['img'] }}" class="card-img-top" alt="{{ $producto['nombre'] }}">
            <div class="card-body text-center">
                <h5 class="card-title">{{ $producto['nombre'] }}</h5>
                <p class="fw-bold text-danger">S/ {{ number_format($producto['precio'], 2) }}</p>

                <form action="/carrito/agregar" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $producto['id'] }}">
                    <input type="hidden" name="nombre" value="{{ $producto['nombre'] }}">
                    <input type="hidden" name="precio" value="{{ $producto['precio'] }}">
                    <button type="submit" class="btn btn-primary">Agregar al carrito </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</div>

<div class="text-center mt-5">
    <a href="{{ route('carrito') }}" class="btn btn-success">Ver carrito </a>
</div>
@endsection
