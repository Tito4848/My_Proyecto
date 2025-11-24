@extends('layouts.app')

@section('title', 'Sobre Nosotros | Sal & Sabor')

@section('content')
<style>
    .hero-about {
        background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    
    .hero-about::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float 20s infinite linear;
    }
    
    .team-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .team-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 15px 40px rgba(214, 40, 40, 0.2);
    }
    
    .team-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        border: 5px solid #d62828;
        object-fit: cover;
    }
    
    .value-card {
        padding: 2rem;
        border-radius: 15px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        transition: all 0.3s ease;
        border-left: 4px solid #d62828;
    }
    
    .value-card:hover {
        transform: translateX(10px);
        box-shadow: 0 10px 30px rgba(214, 40, 40, 0.15);
    }
</style>

<!-- Hero Section -->
<div class="hero-about text-center position-relative">
    <div class="container position-relative">
        <h1 class="display-3 fw-bold mb-3 floating-animation">
            <i class="fas fa-utensils me-3"></i>Sobre Nosotros
        </h1>
        <p class="lead" style="opacity: 0.95;">
            Conoce la historia detrás de Sal & Sabor
        </p>
    </div>
</div>

<div class="container py-5">
    <!-- Nuestra Historia -->
    <div class="row mb-5">
        <div class="col-lg-6 scroll-reveal">
            <h2 class="gradient-text fw-bold mb-4" style="font-size: 2.5rem;">
                <i class="fas fa-book me-2"></i>Nuestra Historia
            </h2>
            <p class="fs-5 text-muted mb-4">
                Sal & Sabor nació del amor por la cocina peruana y el deseo de compartir los sabores auténticos 
                de nuestro país con el mundo. Fundado en 2020, comenzamos como un pequeño restaurante familiar 
                con la misión de ofrecer platos tradicionales preparados con ingredientes frescos y de la más 
                alta calidad.
            </p>
            <p class="fs-5 text-muted mb-4">
                Hoy en día, nos enorgullece ser reconocidos por nuestra cocina auténtica, nuestro servicio 
                excepcional y nuestro compromiso con la satisfacción de nuestros clientes. Cada plato que 
                servimos cuenta una historia y representa la rica tradición culinaria del Perú.
            </p>
            <div class="d-flex gap-3">
                <div class="text-center">
                    <h3 class="fw-bold text-danger">3+</h3>
                    <p class="text-muted mb-0">Años de Experiencia</p>
                </div>
                <div class="text-center">
                    <h3 class="fw-bold text-danger">1000+</h3>
                    <p class="text-muted mb-0">Clientes Satisfechos</p>
                </div>
                <div class="text-center">
                    <h3 class="fw-bold text-danger">50+</h3>
                    <p class="text-muted mb-0">Platos Únicos</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 scroll-reveal">
            <div class="image-zoom">
                <img src="https://imgs.search.brave.com/IX5setiUn6Pmm_6X8I0AT6ITzfemJeZcTK2gY5xzGXQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cuZWF0cGVydS5jb20vd3AtY29udGVudC91cGxvYWRzLzIwMTkvMTAvcG9sbG8tYS1sYS1icmFzYS13aXRoLXNhbGFkLWFuZC1kaXBwaW5nLXNhdWNlcy5qcGc" 
                     alt="Nuestra Historia" 
                     class="img-fluid rounded-4 shadow-lg">
            </div>
        </div>
    </div>

    <!-- Nuestra Misión y Visión -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 scroll-reveal">
            <div class="value-card">
                <div class="mb-3">
                    <i class="fas fa-bullseye fa-3x text-danger"></i>
                </div>
                <h3 class="fw-bold mb-3">Nuestra Misión</h3>
                <p class="text-muted">
                    Ofrecer experiencias culinarias auténticas que celebren la rica tradición gastronómica del Perú, 
                    utilizando ingredientes frescos y técnicas tradicionales, mientras brindamos un servicio 
                    excepcional que haga sentir a nuestros clientes como en casa.
                </p>
            </div>
        </div>
        <div class="col-md-6 scroll-reveal">
            <div class="value-card">
                <div class="mb-3">
                    <i class="fas fa-eye fa-3x text-danger"></i>
                </div>
                <h3 class="fw-bold mb-3">Nuestra Visión</h3>
                <p class="text-muted">
                    Ser reconocidos como el restaurante líder en cocina peruana auténtica, expandiendo nuestros 
                    sabores a nuevas comunidades mientras mantenemos nuestros valores de calidad, tradición y 
                    excelencia en el servicio.
                </p>
            </div>
        </div>
    </div>

    <!-- Nuestros Valores -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center gradient-text fw-bold mb-5 scroll-reveal" style="font-size: 2.5rem;">
                <i class="fas fa-heart me-2"></i>Nuestros Valores
            </h2>
            <div class="row g-4">
                <div class="col-md-4 scroll-reveal">
                    <div class="value-card text-center">
                        <i class="fas fa-leaf fa-3x text-success mb-3"></i>
                        <h4 class="fw-bold mb-3">Frescura</h4>
                        <p class="text-muted">Utilizamos solo ingredientes frescos y de la más alta calidad.</p>
                    </div>
                </div>
                <div class="col-md-4 scroll-reveal">
                    <div class="value-card text-center">
                        <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                        <h4 class="fw-bold mb-3">Tradición</h4>
                        <p class="text-muted">Respetamos y preservamos las recetas tradicionales peruanas.</p>
                    </div>
                </div>
                <div class="col-md-4 scroll-reveal">
                    <div class="value-card text-center">
                        <i class="fas fa-smile fa-3x text-warning mb-3"></i>
                        <h4 class="fw-bold mb-3">Excelencia</h4>
                        <p class="text-muted">Nos esforzamos por superar las expectativas en cada visita.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuestro Equipo -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center gradient-text fw-bold mb-5 scroll-reveal" style="font-size: 2.5rem;">
                <i class="fas fa-users me-2"></i>Nuestro Equipo
            </h2>
            <div class="row g-4">
                <div class="col-md-4 scroll-reveal">
                    <div class="team-card">
                        <img src="https://ui-avatars.com/api/?name=Chef+Juan&background=d62828&color=fff&size=200" 
                             alt="Chef Juan" 
                             class="team-avatar">
                        <h4 class="fw-bold mb-2">Chef Juan Pérez</h4>
                        <p class="text-danger mb-2">Chef Ejecutivo</p>
                        <p class="text-muted small">
                            Con más de 15 años de experiencia en cocina peruana, el Chef Juan es el corazón 
                            de nuestra cocina.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 scroll-reveal">
                    <div class="team-card">
                        <img src="https://ui-avatars.com/api/?name=Maria+Gonzalez&background=d62828&color=fff&size=200" 
                             alt="María González" 
                             class="team-avatar">
                        <h4 class="fw-bold mb-2">María González</h4>
                        <p class="text-danger mb-2">Gerente General</p>
                        <p class="text-muted small">
                            María asegura que cada cliente tenga una experiencia memorable en Sal & Sabor.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 scroll-reveal">
                    <div class="team-card">
                        <img src="https://ui-avatars.com/api/?name=Carlos+Rodriguez&background=d62828&color=fff&size=200" 
                             alt="Carlos Rodríguez" 
                             class="team-avatar">
                        <h4 class="fw-bold mb-2">Carlos Rodríguez</h4>
                        <p class="text-danger mb-2">Sous Chef</p>
                        <p class="text-muted small">
                            Carlos aporta creatividad e innovación mientras mantiene la autenticidad de nuestros platos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card p-5 text-center gradient-animated text-white scroll-reveal">
                <h2 class="fw-bold mb-4">¿Listo para probar nuestros sabores?</h2>
                <p class="lead mb-4">Ven y disfruta de una experiencia culinaria única</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('menu') }}" class="btn btn-light btn-lg hover-lift">
                        <i class="fas fa-utensils me-2"></i>Ver Menú
                    </a>
                    <a href="{{ route('reserva') }}" class="btn btn-outline-light btn-lg hover-lift">
                        <i class="fas fa-calendar-check me-2"></i>Reservar Mesa
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('revealed');
                }, index * 100);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
});
</script>

@endsection

