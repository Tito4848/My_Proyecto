@extends('layouts.admin')

@section('title', 'Platos')

@section('content')
<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-utensils me-2 text-primary"></i>Gestión de Platos</h1>
        <p class="text-muted mb-0">Administra el menú del restaurante</p>
    </div>
    <div>
        <a href="{{ route('admin.platos.create') }}" class="btn btn-modern btn-success hover-glow">
            <i class="fas fa-plus me-2"></i>Nuevo Plato
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
                    <th><i class="fas fa-hashtag me-2"></i>ID</th>
                    <th><i class="fas fa-image me-2"></i>Imagen</th>
                    <th><i class="fas fa-utensils me-2"></i>Nombre</th>
                    <th><i class="fas fa-tag me-2"></i>Precio</th>
                    <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
            </tr>
        </thead>

        <tbody>
                @forelse($platos as $plato)
                    <tr class="animate-fade-in">
                        <td class="fw-bold">#{{ $plato->id }}</td>

                    <td class="text-center">
                        @if($plato->imagen)
                                <div class="image-zoom" style="width: 70px; height: 70px; margin: 0 auto; border-radius: 8px; overflow: hidden;">
                            <img src="{{ asset('images/' . $plato->imagen) }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                        @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 70px; height: 70px; margin: 0 auto;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                        @endif
                    </td>

                        <td class="fw-semibold">{{ $plato->nombre }}</td>
                        <td class="fw-bold text-danger">S/ {{ number_format($plato->precio, 2) }}</td>

                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.platos.edit', $plato) }}" 
                                   class="btn btn-sm btn-modern btn-warning hover-scale"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.platos.destroy', $plato) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este plato?');">
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
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">No hay platos registrados</p>
                            <a href="{{ route('admin.platos.create') }}" class="btn btn-modern btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>Crear primer plato
                            </a>
                    </td>
                </tr>
                @endforelse
        </tbody>
    </table>
    </div>
@endsection
