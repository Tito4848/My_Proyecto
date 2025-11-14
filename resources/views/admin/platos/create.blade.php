@extends('layouts.admin')

@section('title', 'Nuevo Plato')

@section('content')
<h2 class="mb-4">Crear Nuevo Plato</h2>

<form action="{{ route('admin.platos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Nombre --}}
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    {{-- Precio --}}
    <div class="mb-3">
        <label class="form-label">Precio</label>
        <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>

    {{-- Descripción --}}
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4" required></textarea>
    </div>

    {{-- Imagen --}}
    <div class="mb-3">
        <label class="form-label">Imagen (opcional)</label>
        <input type="file" name="imagen" class="form-control">
    </div>

    {{-- Botones --}}
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="{{ route('admin.platos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection
