@extends('layouts.app')

@section('title', 'Delivery | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-gradient fw-bold animate-fade-in" style="font-size: 3rem;">
        <i class="fas fa-truck me-3"></i>Delivery
    </h1>
    <p class="text-center text-muted mb-5 fs-5">
        <i class="fas fa-map-marker-alt me-2 text-danger"></i>¡Llevamos el sabor auténtico del Perú a tu casa!
    </p>

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

    @php
        $carrito = session('carrito', []);
    @endphp

    @if(count($carrito) > 0)
        <!-- Resumen del Carrito -->
        <div class="modern-card p-4 mb-5 animate-fade-in">
            <h3 class="mb-4 fw-bold">
                <i class="fas fa-shopping-bag me-2 text-primary"></i>Tu Pedido
            </h3>
            <div class="row g-4">
                @foreach($carrito as $item)
                    <div class="col-md-4 col-sm-6">
                        <div class="menu-item modern-card h-100">
                            <div class="image-zoom">
                                <img src="{{ asset('images/' . ($item['imagen'] ?? 'nuevo.jpg')) }}" 
                                     class="card-img-top w-100" 
                                     style="height:200px; object-fit:cover;" 
                                     alt="{{ $item['nombre'] }}">
                            </div>
                            <div class="card-body text-center p-3">
                                <h5 class="card-title fw-bold mb-2">{{ $item['nombre'] }}</h5>
                                <p class="text-muted mb-2">
                                    <i class="fas fa-sort-numeric-up me-1"></i>Cantidad: {{ $item['cantidad'] }}
                                </p>
                                <p class="fw-bold text-danger fs-5 mb-0">
                                    S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Formulario de Entrega -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="form-modern p-5 animate-fade-in">
                    <h3 class="mb-4 fw-bold text-center">
                        <i class="fas fa-map-marked-alt me-2 text-primary"></i>Datos de Entrega
                    </h3>
                    <form action="{{ route('delivery.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nombre" class="form-label fw-bold">
                                <i class="fas fa-user me-2 text-primary"></i>Nombre completo
                            </label>
                            <input type="text" name="nombre" id="nombre" 
                                   class="modern-input form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', auth()->user()->name ?? '') }}" 
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="direccion" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Dirección de entrega
                            </label>
                            <textarea name="direccion" id="direccion" rows="3"
                                      class="modern-input form-control @error('direccion') is-invalid @enderror" 
                                      placeholder="Calle, número, distrito, referencia..." 
                                      required>{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="telefono" class="form-label fw-bold">
                                <i class="fas fa-phone me-2 text-primary"></i>Número de contacto
                            </label>
                            <input type="text" name="telefono" id="telefono" 
                                   class="modern-input form-control @error('telefono') is-invalid @enderror" 
                                   placeholder="987654321" 
                                   value="{{ old('telefono') }}" 
                                   required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="metodo_pago" class="form-label fw-bold">
                                <i class="fas fa-credit-card me-2 text-primary"></i>Método de pago
                            </label>
                            <select name="metodo_pago" id="metodo_pago" 
                                    class="modern-input form-select @error('metodo_pago') is-invalid @enderror" 
                                    required>
                                <option value="">Selecciona método de pago</option>
                                <option value="Efectivo" {{ old('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>
                                    <i class="fas fa-money-bill"></i> Efectivo
                                </option>
                                <option value="Tarjeta" {{ old('metodo_pago') == 'Tarjeta' ? 'selected' : '' }}>
                                    <i class="fas fa-credit-card"></i> Tarjeta
                                </option>
                                <option value="Yape" {{ old('metodo_pago') == 'Yape' ? 'selected' : '' }}>
                                    <i class="fas fa-mobile-alt"></i> Yape
                                </option>
                                <option value="Plin" {{ old('metodo_pago') == 'Plin' ? 'selected' : '' }}>
                                    <i class="fas fa-mobile-alt"></i> Plin
                                </option>
                            </select>
                            @error('metodo_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-modern btn-success hover-glow">
                                <i class="fas fa-paper-plane me-2"></i>Confirmar Pedido de Delivery
                            </button>
                            <a href="{{ route('menu') }}" class="btn btn-modern btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Menú
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="text-center animate-fade-in">
            <div class="modern-card p-5" style="max-width: 500px; margin: 0 auto;">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">Tu carrito está vacío</h4>
                <p class="text-muted mb-4">Agrega productos del menú para realizar un pedido de delivery</p>
                <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                    <i class="fas fa-utensils me-2"></i>Ver Menú
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
