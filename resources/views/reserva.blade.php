@extends('layouts.app')

@section('title', 'Reservas | Sal & Sabor')

@section('content')
<div class="container py-5">
    <div class="row align-items-center">
        <!-- Formulario -->
        <div class="col-lg-5 mb-4 animate-slide-in-left">
            <h1 class="text-center mb-4 text-gradient fw-bold" style="font-size: 2.5rem;">
                <i class="fas fa-calendar-check me-2"></i>Reserva tu Mesa
            </h1>

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

            <div class="form-modern p-4">
                <form method="POST" action="{{ route('reserva.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Nombre completo
                        </label>
                        <input type="text" id="nombre" name="nombre" 
                               class="modern-input form-control @error('nombre') is-invalid @enderror" 
                               placeholder="Ingresa tu Nombre" 
                               value="{{ old('nombre') }}" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                    <div class="mb-4">
                        <label for="personas" class="form-label fw-bold">
                            <i class="fas fa-users me-2 text-primary"></i>Cantidad de personas
                        </label>
                        <select id="personas" name="personas" 
                                class="modern-input form-select @error('personas') is-invalid @enderror" 
                                required>
                            <option value="">Selecciona cantidad</option>
                            <option value="1" {{ old('personas') == '1' ? 'selected' : '' }}>1 persona</option>
                            <option value="2" {{ old('personas') == '2' ? 'selected' : '' }}>2 personas</option>
                            <option value="3" {{ old('personas') == '3' ? 'selected' : '' }}>3 personas</option>
                            <option value="4" {{ old('personas') == '4' ? 'selected' : '' }}>4 personas</option>
                            <option value="5" {{ old('personas') == '5' ? 'selected' : '' }}>5 o más</option>
                    </select>
                        @error('personas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                    <div class="mb-4">
                        <label for="fecha" class="form-label fw-bold">
                            <i class="fas fa-calendar me-2 text-primary"></i>Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha" 
                               class="modern-input form-control @error('fecha') is-invalid @enderror" 
                               value="{{ old('fecha') }}" 
                               min="{{ date('Y-m-d') }}" 
                               required>
                        @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                    <div class="mb-4">
                        <label for="hora" class="form-label fw-bold">
                            <i class="fas fa-clock me-2 text-primary"></i>Hora
                        </label>
                        <input type="time" id="hora" name="hora" 
                               class="modern-input form-control @error('hora') is-invalid @enderror" 
                               value="{{ old('hora') }}" 
                               required>
                        @error('hora')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                </div>

                    <button type="submit" class="btn btn-modern btn-primary w-100 hover-glow">
                        <i class="fas fa-check me-2"></i>Confirmar Reserva
                    </button>
            </form>
            </div>
        </div>

        <!-- Imagen -->
        <div class="col-lg-7 animate-slide-in-right">
            <div class="image-zoom">
                <img src="{{ asset('images/reservas.jpg') }}" 
                     alt="Sal & Sabor" 
                     class="img-fluid rounded-4 shadow-soft-lg" 
                     style="width: 100%; max-height: 80vh; object-fit: cover;">
            </div>
        </div>
    </div>
</div>
@endsection
