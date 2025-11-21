@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <div class="form-modern animate-scale-in">
        <div class="card-body p-5">
            <h2 class="text-center text-gradient fw-bold mb-4" style="font-size: 2rem;">
                <i class="fas fa-user-plus me-2"></i>Crear una Cuenta
            </h2>

            @if ($errors->any())
                <x-alert type="error">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label fw-bold">
                        <i class="fas fa-user me-2 text-primary"></i>Nombre completo
                    </label>
                    <input type="text" class="modern-input form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label fw-bold">
                        <i class="fas fa-envelope me-2 text-primary"></i>Correo electrónico
                    </label>
                    <input type="email" class="modern-input form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
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
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>Mínimo 8 caracteres
                    </small>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">
                        <i class="fas fa-lock me-2 text-primary"></i>Confirmar contraseña
                    </label>
                    <input type="password" class="modern-input form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-modern btn-danger w-100 hover-glow">
                    <i class="fas fa-user-plus me-2"></i>Registrarme
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-danger fw-bold hover-scale d-inline-block">
                    <i class="fas fa-sign-in-alt me-1"></i>Inicia sesión
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
