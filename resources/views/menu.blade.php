@extends('layouts.app')
 
@section('title', 'Menú | Sal & Sabor')
 
@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-gradient fw-bold" style="font-size: 3rem; letter-spacing: 2px;">
        <i class="fas fa-utensils me-3"></i>Nuestro Menú
    </h1>
 
@if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
@endif
 
    <div class="text-center mb-5 animate-fade-in">
        <button class="btn btn-modern btn-primary filter-btn me-2 mb-2" data-categoria="todos">
            <i class="fas fa-th me-2"></i>Todos
        </button>
        <button class="btn btn-modern btn-secondary filter-btn me-2 mb-2" data-categoria="Entradas">
            <i class="fas fa-appetizer me-2"></i>Entradas
        </button>
        <button class="btn btn-modern btn-secondary filter-btn me-2 mb-2" data-categoria="Platos principales">
            <i class="fas fa-drumstick-bite me-2"></i>Platos Principales
        </button>
        <button class="btn btn-modern btn-secondary filter-btn me-2 mb-2" data-categoria="Postres">
            <i class="fas fa-birthday-cake me-2"></i>Postres
        </button>
        <button class="btn btn-modern btn-secondary filter-btn mb-2" data-categoria="Bebidas">
            <i class="fas fa-glass-water me-2"></i>Bebidas
        </button>
</div>
 
<div class="row g-4">
        @foreach($platos as $index => $plato)
            <div class="col-md-4 plato scroll-reveal" data-categoria="{{ $plato->categoria ?? 'Plato Principal' }}">
                <div class="menu-item modern-card h-100">
                <!-- Enlace que rodea la imagen y abre el modal -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalPlato{{ $plato->id }}" class="image-zoom d-block">
                        <img src="{{ asset('images/' . $plato->imagen) }}" class="card-img-top w-100" alt="{{ $plato->nombre }}" style="height:250px; object-fit:cover;">
                </a>
                    <div class="card-body text-center p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold mb-0 flex-grow-1" style="color: #333;">{{ $plato->nombre }}</h5>
                            @auth
                            <button class="btn btn-sm btn-link text-danger p-0 ms-2" 
                                    onclick="toggleFavorito({{ $plato->id }})"
                                    title="Agregar a favoritos">
                                <i class="far fa-heart" id="fav-icon-{{ $plato->id }}"></i>
                            </button>
                            @endauth
                        </div>
                        @if($plato->descripcion)
                            <p class="text-muted small mb-3" style="font-size: 0.85rem;">
                                {{ Str::limit($plato->descripcion, 60) }}
                            </p>
                        @endif
                        <p class="fw-bold text-danger fs-4 mb-4">
                            <i class="fas fa-tag me-1"></i>S/ {{ number_format($plato->precio, 2) }}
                        </p>
 
                    <!-- Formulario para agregar al carrito -->
                    <form action="{{ route('carrito.agregar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $plato->id }}">
                        <input type="hidden" name="nombre" value="{{ $plato->nombre }}">
                        <input type="hidden" name="precio" value="{{ $plato->precio }}">
                        <input type="hidden" name="cantidad" value="1">
                            <button type="submit" class="btn btn-modern btn-danger w-100 hover-glow">
                                <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                            </button>
                    </form>
                </div>
            </div>
 
            <!-- Modal para mostrar detalles del plato -->
            <div class="modal fade" id="modalPlato{{ $plato->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $plato->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content modern-card border-0">
                        <div class="modal-header border-0 pb-0">
                            <h5 class="modal-title fw-bold text-gradient" id="modalLabel{{ $plato->id }}" style="font-size: 1.5rem;">
                                <i class="fas fa-utensils me-2"></i>{{ $plato->nombre }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="image-zoom mb-4">
                                <img src="{{ asset('images/' . $plato->imagen) }}" alt="{{ $plato->nombre }}" class="img-fluid rounded shadow-soft">
                            </div>
                            <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Descripción:</h5>
                            <p class="text-muted mb-4">{{ $plato->descripcion }}</p>
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                <h5 class="mb-0 fw-bold">Precio:</h5>
                                <span class="text-danger fw-bold fs-4">S/ {{ number_format($plato->precio, 2) }}</span>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-modern btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cerrar
                            </button>
                            <form action="{{ route('carrito.agregar') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id" value="{{ $plato->id }}">
                                <input type="hidden" name="nombre" value="{{ $plato->nombre }}">
                                <input type="hidden" name="precio" value="{{ $plato->precio }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="btn btn-modern btn-danger hover-glow">
                                    <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
 
 
<div class="text-center mt-5 animate-fade-in">
    <a href="{{ route('carrito') }}" class="btn btn-modern btn-success btn-lg hover-glow">
        <i class="fas fa-shopping-bag me-2"></i>Ver carrito
    </a>
</div>
</div>

<style>
    .filter-btn {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .filter-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 10px 25px rgba(214, 40, 40, 0.3);
    }
    
    .menu-item {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .menu-item:hover {
        transform: translateY(-10px) scale(1.02);
    }
    
    .menu-item img {
        transition: transform 0.5s ease;
    }
    
    .menu-item:hover img {
        transform: scale(1.1);
    }
</style>

<script>
    // Scroll reveal para platos
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
                    }, index * 50);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.plato').forEach(el => {
            observer.observe(el);
        });
    });
    
    const botones = document.querySelectorAll('.filter-btn');
    const platos = document.querySelectorAll('.plato');
 
    botones.forEach(btn => {
        btn.addEventListener('click', () => {
            const categoria = btn.getAttribute('data-categoria');
            let visibleCount = 0;
 
            platos.forEach((plato) => {
                if(categoria.toLowerCase() === 'todos' || plato.dataset.categoria.toLowerCase() === categoria.toLowerCase()) {
                    plato.style.display = 'block';
                    plato.style.animation = `fadeInUp 0.5s ease-out ${visibleCount * 0.05}s both`;
                    visibleCount++;
                } else {
                    plato.style.display = 'none';
                }
            });
 
            botones.forEach(b => {
                b.classList.remove('btn-primary');
                b.classList.add('btn-secondary');
            });
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-primary');
            
            // Animación del botón
            btn.style.transform = 'scale(0.95)';
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
            }, 150);
        });
    });
 
    function toggleFavorito(platoId) {
        const icon = document.getElementById('fav-icon-' + platoId);
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            icon.style.color = '#d62828';
            icon.style.animation = 'bounceIn 0.5s ease-out';
            // Aquí podrías agregar lógica para guardar en favoritos
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            icon.style.color = '';
        }
    }
</script>
@endsection