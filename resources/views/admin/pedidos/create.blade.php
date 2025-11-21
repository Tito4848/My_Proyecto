@extends('layouts.admin')

@section('title', 'Crear Pedido')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Crear Pedido</h2>

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

    <form action="{{ route('admin.pedidos.store') }}" method="POST">
        @csrf

        <div class="card p-4 mb-4">
            <h5>Datos del Cliente</h5>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Método de Pago</label>
                    <select name="metodo_pago" class="form-control @error('metodo_pago') is-invalid @enderror" required>
                        <option value="">Seleccionar</option>
                        <option value="Efectivo" {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="Tarjeta" {{ old('metodo_pago') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="Yape" {{ old('metodo_pago') == 'Yape' ? 'selected' : '' }}>Yape</option>
                        <option value="Plin" {{ old('metodo_pago') == 'Plin' ? 'selected' : '' }}>Plin</option>
                    </select>
                    @error('metodo_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label>Estado</label>
                    <select name="estado" class="form-control @error('estado') is-invalid @enderror" required>
                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="preparando" {{ old('estado') == 'preparando' ? 'selected' : '' }}>En preparación</option>
                        <option value="encamino" {{ old('estado') == 'encamino' ? 'selected' : '' }}>En camino</option>
                        <option value="entregado" {{ old('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Platos dinámicos -->
        <div class="card p-4">
            <h5>Platos del Pedido</h5>

            <table class="table mt-3" id="tabla-platos">
                <thead>
                    <tr>
                        <th>Plato</th>
                        <th style="width: 120px">Cantidad</th>
                        <th style="width: 50px"></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <select name="plato_id[]" class="form-control" required>
                                <option value="">Seleccionar plato</option>
                                @foreach($platos as $plato)
                                    <option value="{{ $plato->id }}">
                                        {{ $plato->nombre }} - S/ {{ $plato->precio }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <input type="number" name="cantidad[]" class="form-control" min="1" value="1" required>
                        </td>

                        <td>
                            <button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-primary" id="agregar-fila">+ Añadir plato</button>
        </div>

        <button class="btn btn-success mt-4">Guardar Pedido</button>

    </form>
</div>

@endsection


@section('scripts')
<script>
document.getElementById('agregar-fila').addEventListener('click', function () {
    let fila = `
        <tr>
            <td>
                <select name="plato_id[]" class="form-control" required>
                    <option value="">Seleccionar plato</option>
                    @foreach($platos as $plato)
                        <option value="{{ $plato->id }}">
                            {{ $plato->nombre }} - S/ {{ $plato->precio }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="cantidad[]" class="form-control" min="1" value="1" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button>
            </td>
        </tr>
    `;

    document.querySelector('#tabla-platos tbody').insertAdjacentHTML('beforeend', fila);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('eliminar-fila')) {
        e.target.closest('tr').remove();
    }
});
</script>
@endsection
