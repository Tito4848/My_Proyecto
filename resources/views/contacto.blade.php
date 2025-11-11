@extends('layouts.app')

@section('title', 'Contacto | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Contáctanos</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h4>Información de contacto</h4>
            <p><strong>Dirección:</strong> Arequipa</p>
            <p><strong>Teléfono:</strong> 999 999 999</p>
            <p><strong>Email:</strong> maycol@gmail.com</p>
            <p><strong>Horario:</strong> Lunes a Domingo, 11:00 a.m. - 11:00 p.m.</p>
        </div>

        <div class="col-md-6">
            <h4>Envíanos un mensaje</h4>
            <form>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" id="nombre" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" id="correo" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea id="mensaje" rows="4" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-danger w-100">Enviar</button>
            </form>
        </div>
    </div>
</div>
@endsection
