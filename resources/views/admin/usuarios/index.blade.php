@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-users me-2 text-primary"></i>Gestión de Usuarios</h1>
        <p class="text-muted mb-0">Administra usuarios y permisos</p>
    </div>
    <div>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-modern btn-primary hover-glow">
            <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
        </a>
    </div>
</div>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    <div class="admin-table animate-fade-in">
        <table class="table table-hover mb-0">
            <thead class="table-light">
            <tr>
                    <th><i class="fas fa-user me-2"></i>Nombre</th>
                    <th><i class="fas fa-envelope me-2"></i>Email</th>
                    <th><i class="fas fa-shield-alt me-2"></i>Rol</th>
                    <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
            </tr>
        </thead>
        <tbody>
                @forelse($usuarios as $usuario)
                    <tr class="animate-fade-in">
                        <td class="fw-semibold">
                            <i class="fas fa-user-circle me-2 text-primary"></i>
                            {{ $usuario->name }}
                        </td>
                        <td>{{ $usuario->email }}</td>

                        <td>
                            @php
                                $rol = $usuario->is_admin
                                    ? 'admin'
                                    : ($usuario->is_employee ? 'empleado' : 'cliente');
                            @endphp

                            @if($rol === 'admin')
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-crown me-1"></i>Administrador
                                </span>
                            @elseif($rol === 'empleado')
                                <span class="badge bg-info p-2">
                                    <i class="fas fa-id-badge me-1"></i>Empleado
                                </span>
                            @else
                                <span class="badge bg-secondary p-2">
                                    <i class="fas fa-user me-1"></i>Cliente
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                   class="btn btn-sm btn-modern btn-warning hover-scale"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                              method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-modern btn-danger hover-scale"
                                            title="Eliminar">
                                        <i class="fas fa-trash"></i>
                            </button>
                        </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">No hay usuarios registrados</p>
                    </td>
                </tr>
                @endforelse
        </tbody>
    </table>
    </div>
</div>
@endsection
