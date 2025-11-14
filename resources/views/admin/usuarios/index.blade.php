@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Gestión de Usuarios</h2>

    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary mb-3">Nuevo Usuario</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>

                    <!-- Mostrar rol correctamente -->
                    <td>
                        @if($usuario->is_admin)
                            <span class="badge bg-success">Administrador</span>
                        @else
                            <span class="badge bg-secondary">Usuario</span>
                        @endif
                    </td>

                    <td class="text-center">
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                           class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                              method="POST"
                              class="d-inline-block"
                              onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
