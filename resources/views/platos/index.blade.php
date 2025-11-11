@extends('layouts.app')

@section('title', 'Menú | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Nuestro Menú</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @foreach($platos as $plato)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/' . $plato->imagen) }}" 
                         class="card-img-top" 
                         alt="{{ $plato->nombre }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $plato->nombre }}</h5>
                        <p class="text-muted">{{ $plato->descripcion }}</p>
                        <p class="fw-bold text-danger fs-5">S/ {{ number_format($plato->precio, 2) }}</p>
                        <form action="{{ route('carrito.agregar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $plato->id }}">
                            <input type="hidden" name="nombre" value="{{ $plato->nombre }}">
                            <input type="hidden" name="precio" value="{{ $plato->precio }}">
                            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('carrito') }}" class="btn btn-success">Ver carrito</a>
    </div>
</div>
@endsection
