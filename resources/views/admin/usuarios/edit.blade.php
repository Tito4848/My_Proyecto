@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Editar Usuario</h2>

    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-4">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="is_admin" class="form-control">
                    <option value="0" {{ !$usuario->is_admin ? 'selected' : '' }}>Usuario normal</option>
                    <option value="1" {{ $usuario->is_admin ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nueva contraseña (opcional)</label>
                <input type="password" name="password" class="form-control">
                <small class="text-muted">
                    Déjala vacía si no deseas cambiarla.
                </small>
            </div>

            <button class="btn btn-primary mt-2">Guardar Cambios</button>
        </div>

    </form>

</div>
@endsection
