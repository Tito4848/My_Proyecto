@extends('layouts.app')

@section('title', 'Mi Perfil | Sal & Sabor')

@section('content')
<div class="container py-5">
    <!-- Header del Perfil -->
    <div class="row mb-5 animate-fade-in">
        <div class="col-12">
            <div class="modern-card p-5 text-center">
                <div class="position-relative d-inline-block mb-4">
                    <div class="avatar-container">
                        @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 class="avatar-image"
                                 id="avatarPreview">
                        @else
                            <div class="avatar-placeholder" id="avatarPreview">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                        @endif
                        <div class="avatar-overlay">
                            <i class="fas fa-camera"></i>
                        </div>
                    </div>
                </div>
                <h1 class="text-gradient fw-bold mb-2" style="font-size: 2.5rem;">
                    {{ $user->name }}
                </h1>
                <p class="text-muted mb-0">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                </p>
                @if($user->is_admin)
                    <span class="badge bg-danger mt-2">
                        <i class="fas fa-crown me-1"></i>Administrador
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if(session('status') === 'profile-updated')
        <x-alert type="success">Perfil actualizado correctamente.</x-alert>
    @endif

    <div class="row g-4">
        <!-- Información del Perfil -->
        <div class="col-lg-8">
            <div class="modern-card p-4 mb-4 animate-fade-in">
                <h3 class="mb-4 fw-bold">
                    <i class="fas fa-user-edit me-2 text-primary"></i>Información del Perfil
                </h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Cambiar Contraseña -->
            <div class="modern-card p-4 mb-4 animate-fade-in" style="animation-delay: 0.1s;">
                <h3 class="mb-4 fw-bold">
                    <i class="fas fa-lock me-2 text-primary"></i>Cambiar Contraseña
                </h3>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Estadísticas -->
            <div class="modern-card p-4 mb-4 animate-fade-in" style="animation-delay: 0.2s;">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-chart-bar me-2 text-primary"></i>Mis Estadísticas
                </h5>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">
                        <i class="fas fa-shopping-bag me-2"></i>Pedidos Totales
                    </span>
                    <span class="fw-bold fs-5 text-primary">{{ $pedidos->count() }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">
                        <i class="fas fa-check-circle me-2"></i>Pedidos Completados
                    </span>
                    <span class="fw-bold fs-5 text-success">
                        {{ $pedidos->where('estado', 'entregado')->count() }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">
                        <i class="fas fa-clock me-2"></i>Pedidos Pendientes
                    </span>
                    <span class="fw-bold fs-5 text-warning">
                        {{ $pedidos->where('estado', 'pendiente')->count() }}
                    </span>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="modern-card p-4 animate-fade-in" style="animation-delay: 0.3s;">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-bolt me-2 text-primary"></i>Acciones Rápidas
                </h5>
                <div class="d-grid gap-2">
                    <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                        <i class="fas fa-utensils me-2"></i>Ver Menú
                    </a>
                    <a href="{{ route('carrito') }}" class="btn btn-modern btn-success hover-lift">
                        <i class="fas fa-shopping-cart me-2"></i>Mi Carrito
                    </a>
                    <a href="{{ route('mis-compras') }}" class="btn btn-modern btn-info hover-lift">
                        <i class="fas fa-history me-2"></i>Mis Compras
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mis Pedidos -->
    @if($pedidos->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-4 animate-fade-in">
                <h3 class="mb-4 fw-bold">
                    <i class="fas fa-receipt me-2 text-primary"></i>Mis Pedidos
                </h3>
                <div class="table-responsive">
                    <table class="table-modern table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>ID</th>
                                <th><i class="fas fa-money-bill-wave me-2"></i>Total</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                <th><i class="fas fa-calendar me-2"></i>Fecha</th>
                                <th class="text-center"><i class="fas fa-cog me-2"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                            <tr>
                                <td class="fw-bold">#{{ $pedido->id }}</td>
                                <td class="fw-bold text-success">S/ {{ number_format($pedido->total, 2) }}</td>
                                <td>
                                    @php
                                        $colors = [
                                            'pendiente' => 'warning',
                                            'preparando' => 'info',
                                            'encamino' => 'primary',
                                            'entregado' => 'success',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$pedido->estado] ?? 'secondary' }}">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-modern btn-primary hover-scale" 
                                            onclick="toggleCarrito({{ $pedido->id }})">
                                        <i class="fas fa-eye"></i> Ver
                                    </button>
                                </td>
                            </tr>
                            <tr id="carrito-{{ $pedido->id }}" style="display:none;" class="table-light">
                                <td colspan="5">
                                    <div class="p-3">
                                        <h6 class="fw-bold mb-3">Detalles del Pedido:</h6>
                                        @php
                                            $items = [];
                                            if($pedido->platos && $pedido->platos->count() > 0) {
                                                foreach($pedido->platos as $plato) {
                                                    $items[] = [
                                                        'nombre' => $plato->nombre,
                                                        'cantidad' => $plato->pivot->cantidad,
                                                        'precio' => $plato->pivot->precio,
                                                    ];
                                                }
                                            } elseif($pedido->carrito && is_array($pedido->carrito)) {
                                                $items = $pedido->carrito;
                                            }
                                        @endphp
                                        <ul class="list-unstyled mb-0">
                                            @foreach($items as $item)
                                                <li class="mb-2">
                                                    <i class="fas fa-utensils me-2 text-primary"></i>
                                                    <strong>{{ $item['nombre'] ?? 'N/A' }}</strong> — 
                                                    Cant: {{ $item['cantidad'] ?? 0 }} — 
                                                    Precio: S/ {{ number_format($item['precio'] ?? 0, 2) }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-5 text-center animate-fade-in">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No tienes pedidos registrados</h5>
                <a href="{{ route('menu') }}" class="btn btn-modern btn-primary mt-3 hover-lift">
                    <i class="fas fa-utensils me-2"></i>Ver Menú
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Eliminar Cuenta -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="modern-card p-4 border-danger animate-fade-in">
                <h5 class="mb-4 fw-bold text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Zona de Peligro
                </h5>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
.avatar-container {
    position: relative;
    display: inline-block;
    cursor: pointer;
}

.avatar-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #d62828;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.avatar-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 4px solid #d62828;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.avatar-overlay {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 45px;
    height: 45px;
    background: #d62828;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 3px solid white;
    box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}

.avatar-container:hover .avatar-overlay {
    transform: scale(1.1);
    background: #b71f1f;
}

.avatar-container:hover .avatar-image,
.avatar-container:hover .avatar-placeholder {
    transform: scale(1.05);
}
</style>

<script>
function toggleCarrito(id) {
    const row = document.getElementById("carrito-" + id);
    row.style.display = row.style.display === "none" ? "" : "none";
}

// Preview de avatar antes de subir
document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatarPreview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        preview.outerHTML = `<img src="${e.target.result}" alt="Preview" class="avatar-image" id="avatarPreview">`;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
