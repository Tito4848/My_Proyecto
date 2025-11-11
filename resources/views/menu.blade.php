@extends('layouts.app')

@section('title', 'Menú | Sal & Sabor')

@section('content')
<h1 class="text-center mb-4">Nuestro Menú</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    @foreach(\App\Models\Plato::all() as $plato)
    <div class="col-md-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('images/' . $plato->imagen) }}" class="card-img-top" alt="{{ $plato->nombre }}" style="height:200px; object-fit:cover;">
            <div class="card-body text-center">
                <h5 class="card-title">{{ $plato->nombre }}</h5>
                <p class="fw-bold text-danger">S/ {{ number_format($plato->precio, 2) }}</p>

                <form action="{{ route('carrito.agregar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $plato->id }}">
                    <input type="hidden" name="nombre" value="{{ $plato->nombre }}">
                    <input type="hidden" name="precio" value="{{ $plato->precio }}">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit" class="btn btn-danger w-100">Agregar al carrito</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="text-center mt-5">
    <a href="{{ route('carrito') }}" class="btn btn-success btn-lg">Ver carrito</a>
</div>
@endsection
