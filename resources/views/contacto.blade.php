@extends('layouts.app')

@section('title', 'Contacto | Sal & Sabor')

@section('content')
<div class="container py-5" style="background-color: #f9f9f9;">
    <h1 class="text-center mb-5" style="font-weight: 700; color: #d63384;">Contáctanos</h1>

    <div class="row">
        <!-- Información de contacto -->
        <div class="col-md-6 mb-4">
            <div class="p-4 bg-white rounded shadow-sm h-100">
                <h4 class="mb-3" style="color: #343a40;">Información de contacto</h4>
                <p><strong>Dirección:</strong> Arequipa</p>
                <p><strong>Teléfono:</strong> 999 999 999</p>
                <p><strong>Email:</strong> maycol@gmail.com</p>
                <p><strong>Horario:</strong> Lunes a Domingo, 11:00 a.m. - 11:00 p.m.</p>
            </div>
        </div>

        <!-- Formulario -->
        <div class="col-md-6">
            <div class="p-4 bg-white rounded shadow-sm">
                <h4 class="mb-3" style="color: #6e4d06ff;">Envíanos un mensaje</h4>
                <form>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" class="form-control" placeholder="Tu nombre completo">
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" id="correo" class="form-control" placeholder="Tu email">
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea id="mensaje" rows="4" class="form-control" placeholder="Escribe tu mensaje aquí"></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger w-100" style="transition: 0.3s;">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estilo extra -->
<style>
    .btn-danger:hover {
        background-color: #c82333;
        transform: scale(1.05);
    }

    input.form-control, textarea.form-control {
        border-radius: 0.5rem;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)!important;
    }
</style>
@endsection
