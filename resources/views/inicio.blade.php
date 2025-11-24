@extends('layouts.app')

@section('title', 'Inicio | Sal & Sabor')

@section('content')

<style>
    .hero-img {
        max-height: 600px;
        object-fit: cover;
        width: 100%;
        transition: transform 0.5s ease;
    }

    .carousel-item:hover .hero-img {
        transform: scale(1.05);
    }

    .section-title {
        font-weight: bold;
        letter-spacing: 1px;
        color: #d62828;
    }

    .carousel-caption {
        background: rgba(0,0,0,0.6);
        padding: 2rem 3rem;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        animation: fadeIn 0.8s ease-out;
    }

    .carousel-caption h5 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .carousel-caption p {
        font-size: 1.2rem;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 60px;
        height: 60px;
        background: rgba(214, 40, 40, 0.9);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        background: rgba(214, 40, 40, 1);
        transform: translateY(-50%) scale(1.15);
    }

    .feature-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }

    .testimonial-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        height: 100%;
    }

    .testimonial-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #d62828;
    }
    
    /* Animaciones modernas */
    .scroll-reveal {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }
    
    .scroll-reveal.revealed {
        opacity: 1;
        transform: translateY(0);
    }
    
    .feature-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .feature-card:hover {
        transform: translateY(-15px) scale(1.02);
    }
    
    .testimonial-card {
        transition: all 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .pulse-icon {
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }
    
    .float-animation {
        animation: floatUpDown 3s ease-in-out infinite;
    }
    
    @keyframes floatUpDown {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #d62828 0%, #b71f1f 50%, #d62828 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: gradientShift 3s linear infinite;
    }
    
    @keyframes gradientShift {
        to {
            background-position: 200% center;
        }
    }
</style>

<!-- =========================
      HERO PRINCIPAL CON CARRUSEL
========================= -->
<section class="text-center bg-white py-5">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner rounded-4 shadow-xl overflow-hidden">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://imgs.search.brave.com/KCq-_oHKjtUtA1iOuiS974257Nlxk-ojnzoR3rDOQ-c/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzA5Lzg3Lzk0LzE1/LzM2MF9GXzk4Nzk0/MTU0N19sUlNKTDVZ/amc0RWh0S3dVVmxO/SHFiQVlibzZmY2FD/WS5qcGc" 
                     class="d-block w-100 hero-img" alt="Ceviche Peruano">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Bienvenido a Sal & Sabor</h5>
                    <p>Descubre los sabores auténticos del Perú 🇵🇪</p>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://imgs.search.brave.com/eNQq8S_0uTC8ifuqsGEo9_f7Lo42oHpwyV908eU-1AM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA5LzY5LzI2Lzcy/LzM2MF9GXzk2OTI2/NzIyMF95amVQYnhy/Z1pRZnB1a2xMdDRO/bk50TkR3U0lsaHpE/MS5qcGc" 
                     class="d-block w-100 hero-img" alt="Lomo Saltado">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Lomo Saltado</h5>
                    <p>Jugoso, sabroso y acompañado de papas fritas caseras.</p>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://imgs.search.brave.com/itHaBVCKJddopkW5LqYWQEWSwD2sTrpp67vutqYf0AQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzE0LzU1LzQ1LzM3/LzM2MF9GXzE0NTU0/NTM3NTlfbnBCdnpx/MllWTm5ncENJNXRl/STVUV0FuWGp3azNw/WjIuanBn" 
                     class="d-block w-100 hero-img" alt="Ají de Gallina">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Ají de Gallina</h5>
                    <p>Una mezcla cremosa y deliciosa que conquista paladares.</p>
                </div>
            </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Botones CTA -->
    <div class="py-5 animate-fade-in">
        <a href="{{ route('menu') }}" class="btn btn-modern btn-red mx-2 px-5 py-3 hover-glow" style="font-size: 1.1rem;">
            <i class="fas fa-utensils me-2"></i>Explorar Menú
        </a>
        <a href="{{ route('reserva') }}" class="btn btn-modern btn-outline-danger mx-2 px-5 py-3 hover-lift" style="font-size: 1.1rem;">
            <i class="fas fa-calendar-check me-2"></i>Reservar Mesa
        </a>
    </div>

    <div class="container">
        <p class="fs-5 mt-4 px-3 animate-fade-in" style="animation-delay: 0.2s; max-width: 800px; margin: 0 auto;">
            <i class="fas fa-heart text-danger me-2"></i>Creemos en los placeres sencillos de la vida.<br>
            <i class="fas fa-leaf text-success me-2"></i>Buena comida, ingredientes frescos y buena vibra.<br>
            <i class="fas fa-home text-primary me-2"></i>Bienvenido a Sal & Sabor, siéntete como en casa.
    </p>
    </div>
</section>

<!-- =========================
  CARACTERÍSTICAS DEL RESTAURANTE
========================= -->
<section class="py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);">
    <div class="container">
        <h2 class="text-center mb-5 gradient-text fw-bold scroll-reveal" style="font-size: 2.5rem;">
            <i class="fas fa-star me-2 float-animation"></i>¿Por qué elegirnos?
        </h2>
        <div class="row g-4">
            <div class="col-md-3 col-sm-6 scroll-reveal">
                <div class="feature-card">
                    <div class="feature-icon bg-danger text-white pulse-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Cocina Auténtica</h4>
                    <p class="text-muted">Recetas tradicionales peruanas preparadas con ingredientes frescos y de calidad.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 scroll-reveal">
                <div class="feature-card">
                    <div class="feature-icon bg-success text-white pulse-icon" style="animation-delay: 0.2s;">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Delivery Rápido</h4>
                    <p class="text-muted">Llevamos el sabor a tu casa con nuestro servicio de delivery rápido y eficiente.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 scroll-reveal">
                <div class="feature-card">
                    <div class="feature-icon bg-warning text-white pulse-icon" style="animation-delay: 0.4s;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Atención 24/7</h4>
                    <p class="text-muted">Estamos disponibles todos los días para servirte con la mejor atención.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 scroll-reveal">
                <div class="feature-card">
                    <div class="feature-icon bg-info text-white pulse-icon" style="animation-delay: 0.6s;">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Hecho con Amor</h4>
                    <p class="text-muted">Cada plato está preparado con dedicación y pasión por la cocina peruana.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================
  SECCIÓN FAVORITA DE LOS FANS
========================= -->
<section class="gradient-soft py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Imagen -->
            <div class="col-md-6 animate-slide-in-left">
                <div class="image-zoom">
                <img src="https://imgs.search.brave.com/IX5setiUn6Pmm_6X8I0AT6ITzfemJeZcTK2gY5xzGXQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/ZWF0cGVydS5jb20v/d3AtY29udGVudC91/cGxvYWRzLzIwMTkv/MTAvcG9sbG8tYS1s/YS1icmFzYS13aXRo/LXNhbGFkLWFuZC1k/aXBwaW5nLXNhdWNl/cy5qcGc"
                         class="img-fluid rounded-4 shadow-soft-lg">
                </div>
            </div>

            <!-- Texto -->
            <div class="col-md-6 animate-slide-in-right">
                <h3 class="section-title mb-2">
                    <i class="fas fa-star me-2"></i>La favorita de los fans
                </h3>
                <h2 class="fw-bold mb-4" style="font-size: 2.5rem;">Pollo a la Brasa</h2>
                <p class="fs-5 mb-4 text-muted">
                    El Pollo a la Brasa es un clásico peruano, jugoso, dorado y lleno de sabor.
                    Servido con papas fritas, ensalada y el toque único de Sal & Sabor.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('menu') }}" class="btn btn-modern btn-red px-5 hover-glow">
                        <i class="fas fa-arrow-right me-2"></i>Ver más
                    </a>
                    <a href="{{ route('delivery') }}" class="btn btn-modern btn-outline-danger px-5 hover-lift">
                        <i class="fas fa-shopping-cart me-2"></i>Pedir ahora
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================
  TESTIMONIOS
========================= -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5 gradient-text fw-bold scroll-reveal" style="font-size: 2.5rem;">
            <i class="fas fa-comments me-2 float-animation"></i>Lo que dicen nuestros clientes
        </h2>
        <div class="row g-4">
            <div class="col-md-4 scroll-reveal">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Maria+Gonzalez&background=d62828&color=fff&size=128" 
                             alt="María" 
                             class="testimonial-avatar me-3">
                        <div>
                            <h6 class="fw-bold mb-0">María González</h6>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-quote-left me-2 text-primary"></i>
                        Excelente comida y servicio. El ceviche es increíble, definitivamente volveré.
                    </p>
                </div>
            </div>
            <div class="col-md-4 scroll-reveal">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Carlos+Rodriguez&background=d62828&color=fff&size=128" 
                             alt="Carlos" 
                             class="testimonial-avatar me-3">
                        <div>
                            <h6 class="fw-bold mb-0">Carlos Rodríguez</h6>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-quote-left me-2 text-primary"></i>
                        El mejor lomo saltado que he probado. La atención es excepcional y los precios justos.
                    </p>
                </div>
            </div>
            <div class="col-md-4 scroll-reveal">
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://ui-avatars.com/api/?name=Ana+Martinez&background=d62828&color=fff&size=128" 
                             alt="Ana" 
                             class="testimonial-avatar me-3">
                        <div>
                            <h6 class="fw-bold mb-0">Ana Martínez</h6>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mb-0">
                        <i class="fas fa-quote-left me-2 text-primary"></i>
                        Ambiente acogedor y comida deliciosa. Perfecto para una cena en familia.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================
  OFERTA ESPECIAL
========================= -->
<section class="py-5" style="background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%); color: white;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 animate-slide-in-left">
                <h2 class="fw-bold mb-4" style="font-size: 2.5rem;">
                    <i class="fas fa-gift me-2"></i>Oferta Especial del Día
                </h2>
                <p class="fs-5 mb-4">
                    ¡Disfruta nuestro menú especial con sabores frescos y deliciosos!
                    Cada día una opción diferente para sorprender tu paladar.
                </p>
                <div class="mb-4">
                    <h3 class="fw-bold mb-2">
                        <i class="fas fa-tag me-2"></i>20% de descuento
                    </h3>
                    <p class="mb-0">En todos los platos principales</p>
                </div>
                <a href="{{ route('menu') }}" class="btn btn-modern btn-light px-5 hover-glow">
                    <i class="fas fa-arrow-right me-2"></i>Ver Ofertas
                </a>
            </div>
            <div class="col-md-6 animate-slide-in-right">
                <div class="image-zoom">
                <img src="https://imgs.search.brave.com/8IJ5H5asWfivMzgxmAilxtAxTR32urnOh3c-jscMrRU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzEyLzM5LzMyLzcw/LzM2MF9GXzEyMzkz/MjcwODdfSUVRM3VH/bDhETXdQY1BUTHFp/QmdMeFd0b0lleU1k/aWEuanBn"
                         class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================
      RESERVA UNA MESA
========================= -->
<section class="gradient-soft py-5">
    <div class="container">
        <h2 class="text-center mb-5 gradient-text fw-bold scroll-reveal" style="font-size: 2.5rem;">
            <i class="fas fa-calendar-check me-2 float-animation"></i>Reserva tu Mesa
        </h2>
        <div class="row justify-content-center align-items-center">
            <!-- Formulario -->
            <div class="col-md-5 scroll-reveal">
                <div class="form-modern p-4">
                    <h4 class="section-title mb-4">
                        <i class="fas fa-utensils me-2"></i>Reserva ahora
                    </h4>
                    <form action="{{ route('reserva.store') }}" method="POST">
                        @csrf
                    <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user me-2 text-primary"></i>Nombre completo
                            </label>
                            <input type="text" name="nombre" class="modern-input form-control" 
                                   placeholder="Tu nombre" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-users me-2 text-primary"></i>Cantidad de personas
                            </label>
                            <select name="personas" class="modern-input form-select" required>
                                <option value="">Selecciona</option>
                                <option value="1">1 persona</option>
                                <option value="2">2 personas</option>
                                <option value="3">3 personas</option>
                                <option value="4">4 personas</option>
                                <option value="5">5 o más</option>
                            </select>
                    </div>
                    <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar me-2 text-primary"></i>Fecha
                            </label>
                            <input type="date" name="fecha" class="modern-input form-control" 
                                   min="{{ date('Y-m-d') }}" value="{{ old('fecha') }}" required>
                    </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock me-2 text-primary"></i>Hora
                            </label>
                            <input type="time" name="hora" class="modern-input form-control" 
                                   value="{{ old('hora') }}" required>
                    </div>
                        <button type="submit" class="btn btn-modern btn-red w-100 hover-glow">
                            <i class="fas fa-check me-2"></i>Reservar Mesa
                        </button>
                </form>
                </div>
            </div>

            <!-- Imagen -->
            <div class="col-md-5 scroll-reveal">
                <div class="image-zoom">
                <img src="https://imgs.search.brave.com/itHaBVCKJddopkW5LqYWQEWSwD2sTrpp67vutqYf0AQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzE0LzU1LzQ1LzM3/LzM2MF9GXzE0NTU0/NTM3NTlfbnBCdnpx/MllWTm5ncENJNXRl/STVUV0FuWGp3azNw/WjIuanBn"
                         class="img-fluid rounded-4 shadow-soft-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Scroll reveal animation
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
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
    
    // Parallax effect for hero
    const hero = document.querySelector('.carousel');
    if (hero) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * 0.5;
            hero.style.transform = `translateY(${rate}px)`;
        });
    }
});
</script>

@endsection
