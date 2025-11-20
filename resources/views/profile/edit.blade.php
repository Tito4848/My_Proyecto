@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="mb-4">Perfil de Usuario</h2>

    {{-- FORMULARIO DE INFORMACIÓN DEL USUARIO --}}
    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- FORMULARIO PARA CAMBIAR CONTRASEÑA --}}
    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- FORMULARIO PARA BORRAR CUENTA --}}
    <div class="card mb-4">
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

    {{-- LISTA DE PEDIDOS --}}
@if(isset($pedidos) && count($pedidos) > 0)
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Mis pedidos</h3>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Ver Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>S/ {{ number_format($pedido->total, 2) }}</td>
                        <td>{{ ucfirst($pedido->estado) }}</td>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="toggleCarrito({{ $pedido->id }})">
                                Ver
                            </button>
                        </td>
                    </tr>

                    {{-- DETALLES DEL PEDIDO (OCULTO) --}}
                    <tr id="carrito-{{ $pedido->id }}" style="display:none;">
                        <td colspan="5">
                            @php
                                $items = json_decode($pedido->carrito, true);
                            @endphp

                            <ul>
                                @foreach($items as $item)
                                    <li>
                                        {{ $item['nombre'] }} —
                                        Cant: {{ $item['cantidad'] }} —
                                        Precio: S/ {{ $item['precio'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <p class="text-muted">No tienes pedidos registrados.</p>
@endif

<script>
function toggleCarrito(id) {
    const row = document.getElementById("carrito-" + id);
    row.style.display = row.style.display === "none" ? "" : "none";
}
</script>


@endsection
