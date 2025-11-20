{{-- resources/views/menu/show.blade.php --}}
@extends('layouts.app')
 
@section('title', $plato->nombre)
 
@section('content')
    <div class="container">
        <h1 class="text-center">{{ $plato->nombre }}</h1>
        <div class="card mb-4">
            <div class="card-body">
                <img src="{{ asset('storage/' . $plato->imagen) }}" alt="{{ $plato->nombre }}" class="img-fluid">
                <h4 class="mt-3">Descripción</h4>
                <p>{{ $plato->descripcion }}</p>
                <h5>Precio: S/ {{ number_format($plato->precio, 2) }}</h5>
 
                <a href="{{ route('carrito.agregar', ['id' => $plato->id]) }}" class="btn btn-primary">Agregar al Carrito</a>
            </div>
        </div>
    </div>
@endsection