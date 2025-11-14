@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('content')
    <div class="container mt-4">

        <h2 class="mb-4">Crear Usuario</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.usuarios.store') }}" method="POST">
            @csrf

            <div class="card p-4">

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="is_admin" class="form-control">
                        <option value="0">Usuario normal</option>
                        <option value="1">Administrador</option>
                    </select>
                </div>

                <button class="btn btn-success">Crear Usuario</button>
            </div>
        </form>

    </div>
@endsection