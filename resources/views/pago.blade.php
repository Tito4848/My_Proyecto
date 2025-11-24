@extends('layouts.app')

@section('title', 'Pago | Sal & Sabor')

@section('content')
<style>
    .payment-method-card {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    
    .payment-method-card:hover {
        border-color: #d62828;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(214, 40, 40, 0.15);
    }
    
    .payment-method-card.active {
        border-color: #d62828;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
        box-shadow: 0 5px 20px rgba(214, 40, 40, 0.2);
    }
    
    .yape-section {
        display: none;
    }
    
    .yape-section.active {
        display: block;
        animation: fadeInUp 0.5s ease-out;
    }
    
    .tarjeta-section {
        display: none;
    }
    
    .tarjeta-section.active {
        display: block;
        animation: fadeInUp 0.5s ease-out;
    }
    
    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .yape-qr-container {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 15px;
        margin-top: 1rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center mb-5 gradient-text fw-bold scroll-reveal" style="font-size: 2.5rem;">
                <i class="fas fa-credit-card me-2 float-animation"></i>Método de Pago
            </h1>

            <!-- Selección de Método de Pago -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 scroll-reveal">
                    <div class="payment-method-card active" data-method="yape" onclick="selectPaymentMethod('yape')">
                        <div class="card-icon bg-success text-white mx-auto">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h5 class="text-center fw-bold mb-2">Yape</h5>
                        <p class="text-center text-muted small mb-0">Pago rápido y seguro</p>
                    </div>
                </div>
                <div class="col-md-6 scroll-reveal">
                    <div class="payment-method-card" data-method="tarjeta" onclick="selectPaymentMethod('tarjeta')">
                        <div class="card-icon bg-primary text-white mx-auto">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h5 class="text-center fw-bold mb-2">Tarjeta de Crédito/Débito</h5>
                        <p class="text-center text-muted small mb-0">Visa, Mastercard, etc.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Formulario de Pago -->
                <div class="col-md-7 scroll-reveal">
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

                        <!-- Sección Yape -->
                        <div id="yape-section" class="yape-section active">
                            <h4 class="mb-4 fw-bold text-success">
                                <i class="fas fa-mobile-alt me-2"></i>Pago con Yape
                            </h4>
                            <form action="{{ route('pago.procesar') }}" method="POST" id="yape-form">
                                @csrf
                                <input type="hidden" name="metodo_pago" value="Yape">
                                
                                <div class="yape-qr-container">
                                    <h5 class="fw-bold mb-3">Escanea el código QR</h5>
                                    <img src="{{ asset('images/QR-MAYCOL.jpg') }}" 
                                         alt="QR de Yape" 
                                         class="img-fluid rounded-lg shadow-lg mb-3" 
                                         style="max-width: 300px;">
                                    <p class="text-muted mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Escanea el código con la app de Yape y confirma el pago
                                    </p>
                                    <div class="mb-4">
                                        <label for="yape_numero" class="form-label fw-bold">
                                            <i class="fas fa-mobile-alt me-2 text-success"></i>Número de Yape
                                        </label>
                                        <input type="text" 
                                               id="yape_numero" 
                                               name="yape_numero" 
                                               class="modern-input form-control" 
                                               placeholder="987654321" 
                                               maxlength="9"
                                               pattern="[0-9]{9}"
                                               oninput="this.value = this.value.replace(/\D/g, '')">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Ingresa tu número de celular registrado en Yape
                                        </small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="yape_codigo" class="form-label fw-bold">
                                            <i class="fas fa-key me-2 text-success"></i>Código de Operación Yape
                                        </label>
                                        <input type="text" 
                                               id="yape_codigo" 
                                               name="yape_codigo" 
                                               class="modern-input form-control" 
                                               placeholder="Ej: 123456"
                                               maxlength="6"
                                               pattern="[0-9]{6}"
                                               oninput="this.value = this.value.replace(/\D/g, '')">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Ingresa el código de 6 dígitos que recibiste después del pago
                                        </small>
                                    </div>
                                    <div class="mb-4">
                                        <label for="nombre_yape" class="form-label fw-bold">
                                            <i class="fas fa-user me-2 text-primary"></i>Nombre Completo
                                        </label>
                                        <input type="text" 
                                               id="nombre_yape" 
                                               name="nombre" 
                                               class="modern-input form-control @error('nombre') is-invalid @enderror" 
                                               placeholder="Tu nombre completo" 
                                               value="{{ old('nombre', auth()->user()->name ?? '') }}" 
                                               required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-modern btn-success w-100 hover-glow">
                                        <i class="fas fa-check-circle me-2"></i>Confirmar Pago con Yape
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Sección Tarjeta -->
                        <div id="tarjeta-section" class="tarjeta-section">
                            <h4 class="mb-4 fw-bold text-primary">
                                <i class="fas fa-credit-card me-2"></i>Pago con Tarjeta
                            </h4>
                            <form action="{{ route('pago.procesar') }}" method="POST" id="tarjeta-form">
                                @csrf
                                <input type="hidden" name="metodo_pago" value="Tarjeta">
                                
                                <div class="mb-4">
                                    <label for="nombre" class="form-label fw-bold">
                                        <i class="fas fa-user me-2 text-primary"></i>Nombre en la Tarjeta
                                    </label>
                                    <input type="text" 
                                           id="nombre" 
                                           name="nombre" 
                                           class="modern-input form-control @error('nombre') is-invalid @enderror" 
                                           placeholder="Ingresa Nombre" 
                                           value="{{ old('nombre', auth()->user()->name ?? '') }}" 
                                           required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="numero" class="form-label fw-bold">
                                        <i class="fas fa-credit-card me-2 text-primary"></i>Número de Tarjeta
                                    </label>
                                    <input type="text" 
                                           id="numero" 
                                           name="numero" 
                                           class="modern-input form-control @error('numero') is-invalid @enderror" 
                                           maxlength="19" 
                                           placeholder="1234 5678 9012 3456" 
                                           value="{{ old('numero') }}" 
                                           required
                                           oninput="formatCardNumber(this); validateCard(this)">
                                    <small id="card-error" class="text-danger d-none"></small>
                                    <small id="card-type" class="text-muted"></small>
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <label for="vencimiento" class="form-label fw-bold">
                                            <i class="fas fa-calendar me-2 text-primary"></i>Vencimiento
                                        </label>
                                        <input type="text" 
                                               id="vencimiento" 
                                               name="vencimiento" 
                                               class="modern-input form-control @error('vencimiento') is-invalid @enderror" 
                                               placeholder="MM/AA" 
                                               maxlength="5" 
                                               value="{{ old('vencimiento') }}" 
                                               required
                                               oninput="formatExpiry(this); validateExpiry(this)">
                                        @error('vencimiento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-4">
                                        <label for="cvv" class="form-label fw-bold">
                                            <i class="fas fa-lock me-2 text-primary"></i>CVV
                                        </label>
                                        <input type="text" 
                                               id="cvv" 
                                               name="cvv" 
                                               class="modern-input form-control @error('cvv') is-invalid @enderror" 
                                               maxlength="4" 
                                               placeholder="123" 
                                               value="{{ old('cvv') }}" 
                                               required
                                               oninput="this.value = this.value.replace(/\D/g, '')">
                                        @error('cvv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-modern btn-primary w-100 hover-glow" id="submit-tarjeta">
                                    <i class="fas fa-check-circle me-2"></i>Confirmar Pago
                                </button>
                            </form>
                        </div>
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

<script>
// Seleccionar método de pago
function selectPaymentMethod(method) {
    // Actualizar cards
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('active');
    });
    document.querySelector(`[data-method="${method}"]`).classList.add('active');
    
    // Mostrar/ocultar secciones
    if (method === 'yape') {
        document.getElementById('yape-section').classList.add('active');
        document.getElementById('tarjeta-section').classList.remove('active');
    } else {
        document.getElementById('tarjeta-section').classList.add('active');
        document.getElementById('yape-section').classList.remove('active');
    }
}

// Formatear número de tarjeta
function formatCardNumber(input) {
    let value = input.value.replace(/\s/g, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    input.value = formattedValue;
}

// Validar tarjeta con algoritmo de Luhn
function validateCard(input) {
    const cardNumber = input.value.replace(/\s/g, '');
    const errorElement = document.getElementById('card-error');
    const typeElement = document.getElementById('card-type');
    
    if (cardNumber.length < 13) {
        errorElement.textContent = 'El número de tarjeta es muy corto';
        errorElement.classList.remove('d-none');
        typeElement.textContent = '';
        return false;
    }
    
    // Algoritmo de Luhn
    let sum = 0;
    let isEven = false;
    
    for (let i = cardNumber.length - 1; i >= 0; i--) {
        let digit = parseInt(cardNumber[i]);
        
        if (isEven) {
            digit *= 2;
            if (digit > 9) {
                digit -= 9;
            }
        }
        
        sum += digit;
        isEven = !isEven;
    }
    
    const isValid = sum % 10 === 0;
    
    // Detectar tipo de tarjeta
    let cardType = '';
    if (cardNumber.startsWith('4')) {
        cardType = 'Visa';
    } else if (cardNumber.startsWith('5') || cardNumber.startsWith('2')) {
        cardType = 'Mastercard';
    } else if (cardNumber.startsWith('3')) {
        cardType = 'American Express';
    }
    
    if (isValid && cardNumber.length >= 13) {
        errorElement.classList.add('d-none');
        typeElement.textContent = cardType ? `✓ ${cardType}` : '✓ Tarjeta válida';
        typeElement.className = 'text-success';
        return true;
    } else {
        errorElement.textContent = 'Número de tarjeta inválido';
        errorElement.classList.remove('d-none');
        typeElement.textContent = '';
        return false;
    }
}

// Formatear fecha de vencimiento
function formatExpiry(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    input.value = value;
}

// Validar fecha de vencimiento
function validateExpiry(input) {
    const value = input.value.replace(/\D/g, '');
    if (value.length === 4) {
        const month = parseInt(value.substring(0, 2));
        const year = parseInt('20' + value.substring(2, 4));
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1;
        
        if (month < 1 || month > 12) {
            input.setCustomValidity('Mes inválido');
        } else if (year < currentYear || (year === currentYear && month < currentMonth)) {
            input.setCustomValidity('La tarjeta ha expirado');
        } else {
            input.setCustomValidity('');
        }
    }
}

// Validar formulario de tarjeta antes de enviar
document.getElementById('tarjeta-form')?.addEventListener('submit', function(e) {
    const cardInput = document.getElementById('numero');
    const expiryInput = document.getElementById('vencimiento');
    
    if (!validateCard(cardInput)) {
        e.preventDefault();
        alert('Por favor, ingresa un número de tarjeta válido');
        return false;
    }
    
    validateExpiry(expiryInput);
    if (!expiryInput.validity.valid) {
        e.preventDefault();
        alert(expiryInput.validationMessage);
        return false;
    }
});

// Validar formulario de Yape
document.getElementById('yape-form')?.addEventListener('submit', function(e) {
    const yapeNumero = document.getElementById('yape_numero').value;
    const yapeCodigo = document.getElementById('yape_codigo').value;
    
    if (yapeNumero.length !== 9) {
        e.preventDefault();
        alert('El número de Yape debe tener 9 dígitos');
        return false;
    }
    
    if (yapeCodigo.length !== 6) {
        e.preventDefault();
        alert('El código de operación Yape debe tener 6 dígitos');
        return false;
    }
});
</script>

@endsection
