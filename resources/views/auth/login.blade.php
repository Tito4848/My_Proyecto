@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 500px;">
    <div class="form-modern animate-scale-in">
        <div class="card-body p-5">
            <h2 class="text-center text-gradient fw-bold mb-4" style="font-size: 2rem;">
                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
            </h2>

            @if (session('status'))
                <x-alert type="success">{{ session('status') }}</x-alert>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold">
                        <i class="fas fa-envelope me-2 text-primary"></i>Correo electrónico
                    </label>
                    <input type="email" class="modern-input form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">
                        <i class="fas fa-lock me-2 text-primary"></i>Contraseña
                    </label>
                    <input type="password" class="modern-input form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-danger small">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn btn-modern btn-danger w-100 hover-glow">
                    <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="text-danger fw-bold hover-scale d-inline-block">
                    <i class="fas fa-user-plus me-1"></i>Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
