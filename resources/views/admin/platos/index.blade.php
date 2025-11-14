@extends('layouts.admin')

@section('title', 'Platos')

@section('content')
    <h2 class="mb-4">Gestión de Platos</h2>

    <a href="{{ route('admin.platos.create') }}" class="btn btn-success mb-3">
        Agregar nuevo plato
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($platos as $plato)
                <tr>
                    <td>{{ $plato->id }}</td>

                    <td class="text-center">
                        @if($plato->imagen)
                            <img src="{{ asset('images/' . $plato->imagen) }}"
                                 style="width: 70px; height: 70px; object-fit: cover; border: 1px solid #ccc;">
                        @else
                            <small>No tiene</small>
                        @endif
                    </td>

                    <td>{{ $plato->nombre }}</td>
                    <td>S/ {{ number_format($plato->precio, 2) }}</td>

                    <td class="text-center">
                        <a href="{{ route('admin.platos.edit', $plato) }}" class="btn btn-warning btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('admin.platos.destroy', $plato) }}" 
                              method="POST" class="d-inline-block"
                              onsubmit="return confirm('¿Eliminar plato?');">
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
@endsection
