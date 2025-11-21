@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Editar Usuario</h2>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if ($errors->any())
        <x-alert type="error">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card p-4">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $usuario->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $usuario->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="is_admin" class="form-control @error('is_admin') is-invalid @enderror">
                    <option value="0" {{ old('is_admin', $usuario->is_admin) == '0' ? 'selected' : '' }}>Usuario normal</option>
                    <option value="1" {{ old('is_admin', $usuario->is_admin) == '1' ? 'selected' : '' }}>Administrador</option>
                </select>
                @error('is_admin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nueva contraseña (opcional)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">
                    Déjala vacía si no deseas cambiarla. Mínimo 8 caracteres si la cambias.
                </small>
            </div>

            <button class="btn btn-primary mt-2">Guardar Cambios</button>
        </div>

    </form>

</div>
@endsection
