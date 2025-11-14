@extends('layouts.admin')

@section('title', 'Crear Pedido')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Crear Pedido</h2>

    <form action="{{ route('admin.pedidos.store') }}" method="POST">
        @csrf

        <div class="card p-4 mb-4">
            <h5>Datos del Cliente</h5>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Método de Pago</label>
                    <select name="metodo_pago" class="form-control" required>
                        <option value="">Seleccionar</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Yape">Yape</option>
                        <option value="Plin">Plin</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="preparando">En preparación</option>
                        <option value="encamino">En camino</option>
                        <option value="entregado">Entregado</option>
                    </select>
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
