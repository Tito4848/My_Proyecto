@extends('layouts.app')

@section('title', 'Contacto | Sal & Sabor')

@section('content')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%);
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    
    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float 20s infinite linear;
    }
    
    @keyframes float {
        0% { transform: translateY(0); }
        100% { transform: translateY(-100px); }
    }
    
    .contact-info-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(214, 40, 40, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    .contact-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(214, 40, 40, 0.05), transparent);
        transition: left 0.5s;
    }
    
    .contact-info-card:hover::before {
        left: 100%;
    }
    
    .contact-info-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(214, 40, 40, 0.2);
    }
    
    .info-item {
        padding: 1.5rem;
        margin-bottom: 1rem;
        border-radius: 15px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        animation: slideInLeft 0.6s ease-out backwards;
    }
    
    .info-item:nth-child(1) { animation-delay: 0.1s; }
    .info-item:nth-child(2) { animation-delay: 0.2s; }
    .info-item:nth-child(3) { animation-delay: 0.3s; }
    .info-item:nth-child(4) { animation-delay: 0.4s; }
    .info-item:nth-child(5) { animation-delay: 0.5s; }
    
    .info-item:hover {
        transform: translateX(10px);
        border-left-color: #d62828;
        box-shadow: 0 5px 20px rgba(214, 40, 40, 0.15);
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1rem;
        transition: all 0.3s ease;
    }
    
    .info-item:hover .info-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .form-modern {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-group-animated {
        position: relative;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.6s ease-out backwards;
    }
    
    .form-group-animated:nth-child(1) { animation-delay: 0.1s; }
    .form-group-animated:nth-child(2) { animation-delay: 0.2s; }
    .form-group-animated:nth-child(3) { animation-delay: 0.3s; }
    .form-group-animated:nth-child(4) { animation-delay: 0.4s; }
    
    .modern-input {
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }
    
    .modern-input:focus {
        border-color: #d62828;
        box-shadow: 0 0 0 0.2rem rgba(214, 40, 40, 0.15);
        transform: translateY(-2px);
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .social-link {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        animation: scaleIn 0.5s ease-out backwards;
    }
    
    .social-link:nth-child(1) { animation-delay: 0.1s; }
    .social-link:nth-child(2) { animation-delay: 0.2s; }
    .social-link:nth-child(3) { animation-delay: 0.3s; }
    .social-link:nth-child(4) { animation-delay: 0.4s; }
    
    .social-link:hover {
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        margin-top: 2rem;
        animation: fadeIn 1s ease-out;
    }
    
    .floating-animation {
        animation: floatUpDown 3s ease-in-out infinite;
    }
    
    @keyframes floatUpDown {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .pulse-animation {
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
</style>

<!-- Hero Section -->
<div class="contact-hero text-center">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold mb-3 floating-animation" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.3);">
            <i class="fas fa-envelope me-3"></i>Contáctanos
        </h1>
        <p class="lead mb-0" style="opacity: 0.95;">
            Estamos aquí para ayudarte. ¡Escríbenos y te responderemos pronto!
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Información de contacto -->
        <div class="col-lg-5">
            <div class="contact-info-card animate-slide-in-left">
                <h3 class="mb-4 fw-bold text-gradient">
                    <i class="fas fa-info-circle me-2"></i>Información de Contacto
                </h3>
                
                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon bg-danger text-white">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Dirección</strong>
                            <span class="text-muted">Arequipa, Perú</span>
                        </div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon bg-success text-white">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Teléfono</strong>
                            <span class="text-muted">999 999 999</span>
                        </div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon bg-primary text-white">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Email</strong>
                            <span class="text-muted">maycol@gmail.com</span>
                        </div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon bg-warning text-white">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Horario de Atención</strong>
                            <span class="text-muted">Lunes a Domingo<br>11:00 a.m. - 11:00 p.m.</span>
                        </div>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="d-flex align-items-center">
                        <div class="info-icon bg-info text-white">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div>
                            <strong class="d-block mb-1">Delivery</strong>
                            <span class="text-muted">Disponible todos los días<br>Zona de cobertura: Arequipa</span>
                        </div>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                <div class="mt-4 pt-4 border-top">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-share-alt me-2 text-primary"></i>Síguenos
                    </h5>
                    <div class="social-links">
                        <a href="#" class="social-link bg-primary pulse-animation" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link bg-danger pulse-animation" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link bg-success pulse-animation" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-link bg-info pulse-animation" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Mapa -->
            <div class="map-container animate-fade-in" style="animation-delay: 0.3s;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3826.5!2d-71.5350!3d-16.4090!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDI0JzMyLjQiUyA3McKwMzInMDYuMCJX!5e0!3m2!1ses!2spe!4v1234567890"
                    width="100%" 
                    height="300" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Formulario -->
        <div class="col-lg-7">
            <div class="form-modern animate-slide-in-right">
                <h3 class="mb-4 fw-bold text-gradient">
                    <i class="fas fa-paper-plane me-2"></i>Envíanos un Mensaje
                </h3>
                <p class="text-muted mb-4">
                    Completa el formulario y nos pondremos en contacto contigo lo antes posible.
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

                <form method="POST" action="{{ route('contacto.enviar') }}" id="contactForm">
                    @csrf
                    <div class="form-group-animated">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Nombre Completo
                        </label>
                        <input type="text" 
                               id="nombre" 
                               name="nombre" 
                               class="modern-input form-control @error('nombre') is-invalid @enderror" 
                               placeholder="Ingresa tu nombre completo" 
                               value="{{ old('nombre') }}" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-animated">
                        <label for="correo" class="form-label fw-bold">
                            <i class="fas fa-envelope me-2 text-primary"></i>Correo Electrónico
                        </label>
                        <input type="email" 
                               id="correo" 
                               name="correo" 
                               class="modern-input form-control @error('correo') is-invalid @enderror" 
                               placeholder="tu@email.com" 
                               value="{{ old('correo') }}" 
                               required>
                        @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-animated">
                        <label for="mensaje" class="form-label fw-bold">
                            <i class="fas fa-comment me-2 text-primary"></i>Mensaje
                        </label>
                        <textarea id="mensaje" 
                                  name="mensaje" 
                                  rows="6" 
                                  class="modern-input form-control @error('mensaje') is-invalid @enderror" 
                                  placeholder="Escribe tu mensaje aquí..." 
                                  required>{{ old('mensaje') }}</textarea>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>Mínimo 10 caracteres
                        </small>
                        @error('mensaje')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-animated">
                        <button type="submit" class="btn btn-modern btn-danger w-100 hover-glow" style="padding: 15px; font-size: 1.1rem;">
                            <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de entrada para elementos
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.info-item, .form-group-animated').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease-out';
        observer.observe(el);
    });
    
    // Efecto de typing en el textarea
    const textarea = document.getElementById('mensaje');
    if (textarea) {
        textarea.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        textarea.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
});
</script>

@endsection
