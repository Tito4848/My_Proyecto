@extends('layouts.app')

@section('title', 'Administrar Platos')

@section('content')
<div class="container mt-5">
    <h1>Gestión de Platos</h1>
    <a href="{{ route('platos.create') }}" class="btn btn-success mb-3">Agregar nuevo plato</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($platos as $plato)
            <tr>
                <td>{{ $plato->nombre }}</td>
                <td>S/ {{ number_format($plato->precio, 2) }}</td>
                <td>
                    <a href="{{ route('platos.edit', $plato->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('platos.destroy', $plato->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
