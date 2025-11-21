@extends('layouts.app')

@section('title', 'Tu Carrito | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 text-gradient fw-bold animate-fade-in" style="font-size: 3rem;">
        <i class="fas fa-shopping-cart me-3"></i>Tu Carrito
    </h1>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    @if(session('warning'))
        <x-alert type="warning">{{ session('warning') }}</x-alert>
    @endif

    {{-- Si hay productos en el carrito --}}
    @if(session('carrito') && count(session('carrito')) > 0)
        <div class="table-responsive animate-fade-in">
            <table class="table-modern table table-hover text-center align-middle shadow-soft">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-box me-2"></i>Producto</th>
                        <th><i class="fas fa-tag me-2"></i>Precio (S/)</th>
                        <th><i class="fas fa-sort-numeric-up me-2"></i>Cantidad</th>
                        <th><i class="fas fa-calculator me-2"></i>Subtotal (S/)</th>
                        <th><i class="fas fa-cog me-2"></i>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('carrito') as $id => $item)
                        @php 
                            $subtotal = $item['precio'] * $item['cantidad']; 
                            $total += $subtotal;
                        @endphp
                        <tr class="cart-item animate-fade-in">
                            <td class="fw-semibold">
                                <i class="fas fa-utensils me-2 text-primary"></i>{{ $item['nombre'] }}
                            </td>
                            <td class="text-danger fw-bold">S/ {{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <span class="badge-modern bg-primary text-white">{{ $item['cantidad'] }}</span>
                            </td>
                            <td class="text-success fw-bold">S/ {{ number_format($subtotal, 2) }}</td>
                            <td>
                                {{-- Botón eliminar producto individual --}}
                                <form action="{{ route('carrito.eliminar', ['id' => $id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-modern btn-sm btn-danger hover-scale">
                                        <i class="fas fa-trash me-1"></i>Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div class="text-end mt-5 animate-fade-in">
            <div class="modern-card p-4 d-inline-block">
                <h4 class="fw-bold mb-0">
                    <i class="fas fa-receipt me-2 text-primary"></i>
                    Total: <span class="text-danger fs-3">S/ {{ number_format($total, 2) }}</span>
                </h4>
            </div>
        </div>

        {{-- BOTONES --}}
        <div class="d-flex justify-content-center mt-5 gap-3 flex-wrap animate-fade-in">
            <a href="{{ route('menu') }}" class="btn btn-modern btn-secondary hover-lift">
                <i class="fas fa-arrow-left me-2"></i>Seguir comprando
            </a>

            {{-- Vaciar carrito --}}
            <form action="{{ route('vaciar') }}" method="POST" onsubmit="return confirm('¿Seguro que deseas vaciar el carrito?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-modern btn-warning hover-scale">
                    <i class="fas fa-trash-alt me-2"></i>Vaciar carrito
                </button>
            </form>

            {{-- Ir al pago --}}
            <a href="{{ route('pago') }}" class="btn btn-modern btn-danger hover-glow">
                <i class="fas fa-credit-card me-2"></i>Continuar con el pago
            </a>
        </div>
    @else
        {{-- CARRITO VACÍO --}}
        <div class="text-center animate-fade-in">
            <div class="modern-card p-5" style="max-width: 500px; margin: 0 auto;">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <x-alert type="info" :dismissible="false">
                    <strong>Tu carrito está vacío.</strong> Agrega productos del menú para continuar.
                </x-alert>
                <div class="mt-4">
                    <a href="{{ route('menu') }}" class="btn btn-modern btn-primary hover-lift">
                        <i class="fas fa-utensils me-2"></i>Ver menú
                    </a>
                </div>
        </div>
        </div>
    @endif
</div>
@endsection
