@extends('layouts.app')

@section('title', 'Pago | Sal & Sabor')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center mb-5 text-gradient fw-bold animate-fade-in" style="font-size: 2.5rem;">
                <i class="fas fa-credit-card me-2"></i>Pago con Tarjeta
            </h1>

            <div class="row g-4">
                <!-- Formulario de Pago -->
                <div class="col-md-7 animate-slide-in-left">
                    <div class="form-modern p-4">
                        @if(session('success'))
                            <x-alert type="success">{{ session('success') }}</x-alert>
                        @endif

                        @if(session('error'))
                            <x-alert type="error">{{ session('error') }}</x-alert>
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

                        <form action="{{ route('pago.procesar') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nombre" class="form-label fw-bold">
                                    <i class="fas fa-user me-2 text-primary"></i>Nombre en la Tarjeta
                                </label>
                                <input type="text" id="nombre" name="nombre" 
                                       class="modern-input form-control @error('nombre') is-invalid @enderror" 
                                       placeholder="Ingresa Nombre" 
                                       value="{{ old('nombre') }}" 
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="numero" class="form-label fw-bold">
                                    <i class="fas fa-credit-card me-2 text-primary"></i>Número de Tarjeta
                                </label>
                                <input type="text" id="numero" name="numero" 
                                       class="modern-input form-control @error('numero') is-invalid @enderror" 
                                       maxlength="16" 
                                       placeholder="1234 5678 9012 3456" 
                                       value="{{ old('numero') }}" 
                                       required
                                       oninput="this.value = this.value.replace(/\s/g, '').replace(/(.{4})/g, '$1 ').trim()">
                                @error('numero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-6 mb-4">
                                    <label for="vencimiento" class="form-label fw-bold">
                                        <i class="fas fa-calendar me-2 text-primary"></i>Vencimiento
                                    </label>
                                    <input type="text" id="vencimiento" name="vencimiento" 
                                           class="modern-input form-control @error('vencimiento') is-invalid @enderror" 
                                           placeholder="MM/AA" 
                                           maxlength="5" 
                                           value="{{ old('vencimiento') }}" 
                                           required
                                           oninput="this.value = this.value.replace(/\D/g, '').replace(/(\d{2})(\d)/, '$1/$2')">
                                    @error('vencimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-4">
                                    <label for="cvv" class="form-label fw-bold">
                                        <i class="fas fa-lock me-2 text-primary"></i>CVV
                                    </label>
                                    <input type="text" id="cvv" name="cvv" 
                                           class="modern-input form-control @error('cvv') is-invalid @enderror" 
                                           maxlength="3" 
                                           placeholder="123" 
                                           value="{{ old('cvv') }}" 
                                           required
                                           oninput="this.value = this.value.replace(/\D/g, '')">
                                    @error('cvv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-modern btn-success w-100 hover-glow">
                                <i class="fas fa-check-circle me-2"></i>Confirmar Pago
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Resumen del Pedido -->
                <div class="col-md-5 animate-slide-in-right">
                    <div class="modern-card p-4 sticky-top" style="top: 2rem;">
                        <h4 class="fw-bold mb-4">
                            <i class="fas fa-receipt me-2 text-primary"></i>Resumen del Pedido
                        </h4>
                        
                        @if(session('carrito'))
                            <div class="mb-4">
                                @foreach(session('carrito') as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $item['nombre'] }}</h6>
                                            <small class="text-muted">Cantidad: {{ $item['cantidad'] }}</small>
                                        </div>
                                        <span class="fw-bold text-success">
                                            S/ {{ number_format($item['precio'] * $item['cantidad'], 2) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-bold">S/ {{ number_format($total * 0.82, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">IGV (18%):</span>
                            <span class="fw-bold">S/ {{ number_format($total * 0.18, 2) }}</span>
                        </div>
                        <div class="border-top pt-3 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Total:</h5>
                                <h4 class="mb-0 fw-bold text-danger">S/ {{ number_format($total, 2) }}</h4>
                            </div>
                        </div>

                      <!-- QR de Yape -->
<div class="mt-4 text-center">
    <h6 class="fw-semibold mb-2">Paga con Yape</h6>
    <img src="{{ asset('images/QR-MAYCOL.jpg') }}" alt="QR de Yape" class="mx-auto w-40 h-40 rounded-lg shadow-md">
    <p class="text-muted mt-2">Escanea este código con Yape para completar tu pago.</p>
</div>


                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1 text-success"></i>
                                Pago seguro y encriptado
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
