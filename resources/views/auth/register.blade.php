@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h2 class="text-center text-danger fw-bold mb-4">Crear una Cuenta</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nombre completo</label>
                    <input type="text" class="form-control" id="name" name="name" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-danger w-100">Registrarme</button>
            </form>

            <p class="text-center mt-3 mb-0">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-danger fw-bold">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
@endsection
