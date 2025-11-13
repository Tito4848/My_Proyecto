@extends('layouts.app')

@section('title', 'Reservas | Sal & Sabor')

@section('content')
<div class="container my-5">
    <div class="row align-items-center">
        <!-- Formulario -->
        <div class="col-lg-5 mb-4">
            <h1 class="text-center mb-4">Reserva tu Mesa</h1>

            <form class="mx-auto p-4 border rounded shadow" style="background-color: #fff;">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ingresa tu Nombre">
                </div>

                <div class="mb-3">
                    <label for="personas" class="form-label">Cantidad de personas</label>
                    <select id="personas" class="form-select">
                        <option>1 persona</option>
                        <option>2 personas</option>
                        <option>3 personas</option>
                        <option>4 personas</option>
                        <option>5 o más</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" id="fecha" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" id="hora" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100">Reservar</button>
            </form>
        </div>

        <!-- Imagen -->
        <div class="col-lg-7">
            <img src="{{ asset('images/reservas.jpg') }}" alt="Sal & Sabor" class="img-fluid rounded shadow" style="width: 100%; max-height: 80vh; object-fit: cover;">
        </div>
    </div>
</div>
@endsection
