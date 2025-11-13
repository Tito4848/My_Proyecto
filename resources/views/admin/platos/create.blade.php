@extends('layouts.app')

@section('title', 'Agregar Plato')

@section('content')
<div class="container mt-5">
    <h1>Agregar Nuevo Plato</h1>

    <form action="{{ route('platos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label>Imagen</label>
            <input type="file" name="imagen" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Agregar</button>
    </form>
</div>
@endsection
