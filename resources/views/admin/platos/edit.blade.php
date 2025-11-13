@extends('layouts.app')

@section('title', 'Editar Plato')

@section('content')
<div class="container mt-5">
    <h1>Editar Plato</h1>

    <form action="{{ route('platos.update', $plato->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $plato->nombre }}" required>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="{{ $plato->precio }}" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3">{{ $plato->descripcion }}</textarea>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
            @if($plato->imagen)
                <img src="{{ asset('images/' . $plato->imagen) }}" alt="" class="img-fluid mt-2" width="150">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
