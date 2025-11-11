@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h2 class="text-center text-danger fw-bold mb-4">Iniciar Sesión</h2>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Correo electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-danger small">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn btn-danger w-100">Ingresar</button>
            </form>

            <p class="text-center mt-3 mb-0">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="text-danger fw-bold">Regístrate aquí</a>
            </p>
        </div>
    </div>
</div>
@endsection
