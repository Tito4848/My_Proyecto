@extends('layouts.app')

@section('title', 'Contacto | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-gradient fw-bold animate-fade-in" style="font-size: 3rem;">
        <i class="fas fa-envelope me-3"></i>Contáctanos
    </h1>

    <div class="row">
        <!-- Información de contacto -->
        <div class="col-md-6 mb-4 animate-slide-in-left">
            <div class="modern-card p-5 h-100 hover-lift">
                <h4 class="mb-4 fw-bold">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Información de contacto
                </h4>
                <div class="mb-3">
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                        <strong>Dirección:</strong> Arequipa
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2 text-success"></i>
                        <strong>Teléfono:</strong> 999 999 999
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        <strong>Email:</strong> maycol@gmail.com
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-clock me-2 text-warning"></i>
                        <strong>Horario:</strong> Lunes a Domingo, 11:00 a.m. - 11:00 p.m.
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div class="col-md-6 animate-slide-in-right">
            <div class="form-modern">
                <h4 class="mb-4 fw-bold text-gradient">
                    <i class="fas fa-paper-plane me-2"></i>Envíanos un mensaje
                </h4>
                
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

                <form method="POST" action="{{ route('contacto.enviar') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Nombre
                        </label>
                        <input type="text" id="nombre" name="nombre" class="modern-input form-control @error('nombre') is-invalid @enderror" placeholder="Tu nombre completo" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="correo" class="form-label fw-bold">
                            <i class="fas fa-envelope me-2 text-primary"></i>Correo electrónico
                        </label>
                        <input type="email" id="correo" name="correo" class="modern-input form-control @error('correo') is-invalid @enderror" placeholder="Tu email" value="{{ old('correo') }}" required>
                        @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="mensaje" class="form-label fw-bold">
                            <i class="fas fa-comment me-2 text-primary"></i>Mensaje
                        </label>
                        <textarea id="mensaje" name="mensaje" rows="4" class="modern-input form-control @error('mensaje') is-invalid @enderror" placeholder="Escribe tu mensaje aquí" required>{{ old('mensaje') }}</textarea>
                        @error('mensaje')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-modern btn-danger w-100 hover-glow">
                        <i class="fas fa-paper-plane me-2"></i>Enviar mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
