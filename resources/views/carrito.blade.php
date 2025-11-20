@extends('layouts.app')

@section('title', 'Tu Carrito | Sal & Sabor')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Tu Carrito</h1>

    {{-- Si hay productos en el carrito --}}
    @if(session('carrito') && count(session('carrito')) > 0)
        <div class="table-responsive">
            <table class="table table-striped text-center align-middle shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio (S/)</th>
                        <th>Cantidad</th>
                        <th>Subtotal (S/)</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach(session('carrito') as $id => $item)
                        @php 
                            $subtotal = $item['precio'] * $item['cantidad']; 
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $item['nombre'] }}</td>
                            <td>{{ number_format($item['precio'], 2) }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>{{ number_format($subtotal, 2) }}</td>
                            <td>
                                {{-- Botón eliminar producto individual --}}
                                <form action="{{ route('carrito.eliminar', ['id' => $id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div class="text-end mt-4">
            <h4 class="fw-bold">Total: S/ {{ number_format($total, 2) }}</h4>
        </div>

        {{-- BOTONES --}}
        <div class="d-flex justify-content-center mt-4 gap-3 flex-wrap">
            <a href="{{ route('menu') }}" class="btn btn-secondary">Seguir comprando</a>

            {{-- Vaciar carrito --}}
            <form action="{{ route('vaciar') }}" method="POST" onsubmit="return confirm('¿Seguro que deseas vaciar el carrito?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning">Vaciar carrito</button>
            </form>

            {{-- Ir al pago --}}
            <a href="{{ route('pago') }}" class="btn btn-danger">Continuar con el pago</a>

        </div>
    @else
        {{-- CARRITO VACÍO --}}
        <div class="alert alert-info text-center mt-5">
            Tu carrito está vacío.
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('menu') }}" class="btn btn-primary">Ver menú</a>
        </div>
    @endif
</div>
@endsection
