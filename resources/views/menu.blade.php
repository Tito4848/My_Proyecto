@extends('layouts.app')
 
@section('title', 'Menú | Sal & Sabor')
 
@section('content')
<h1 class="text-center mb-4">Nuestro Menú</h1>
 
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
 
<div class="text-center mb-4">
    <button class="btn btn-primary filter-btn" data-categoria="todos">Todos</button>
    <button class="btn btn-secondary filter-btn" data-categoria="Entradas">Entradas</button>
    <button class="btn btn-secondary filter-btn" data-categoria="Platos principales">Platos Principales</button>
    <button class="btn btn-secondary filter-btn" data-categoria="Postres">Postres</button>
    <button class="btn btn-secondary filter-btn" data-categoria="Bebidas">Bebidas</button>
</div>
 
<div class="row g-4">
    @foreach($platos as $plato)
        <div class="col-md-4 plato" data-categoria="{{ $plato->categoria ?? 'Plato Principal' }}">
            <div class="card h-100 shadow-sm">
                <!-- Enlace que rodea la imagen y abre el modal -->
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalPlato{{ $plato->id }}">
                    <img src="{{ asset('images/' . $plato->imagen) }}" class="card-img-top" alt="{{ $plato->nombre }}" style="height:200px; object-fit:cover;">
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $plato->nombre }}</h5>
                    <p class="fw-bold text-danger">S/ {{ number_format($plato->precio, 2) }}</p>
 
                    <!-- Formulario para agregar al carrito -->
                    <form action="{{ route('carrito.agregar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $plato->id }}">
                        <input type="hidden" name="nombre" value="{{ $plato->nombre }}">
                        <input type="hidden" name="precio" value="{{ $plato->precio }}">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn btn-danger w-100">Agregar al carrito</button>
                    </form>
                </div>
            </div>
 
            <!-- Modal para mostrar detalles del plato -->
            <div class="modal fade" id="modalPlato{{ $plato->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $plato->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel{{ $plato->id }}">{{ $plato->nombre }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset('images/' . $plato->imagen) }}" alt="{{ $plato->nombre }}" class="img-fluid mb-3">
                            <h5>Descripción:</h5>
                            <p>{{ $plato->descripcion }}</p>
                            <h5>Precio: S/ {{ number_format($plato->precio, 2) }}</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <form action="{{ route('carrito.agregar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $plato->id }}">
                                <input type="hidden" name="nombre" value="{{ $plato->nombre }}">
                                <input type="hidden" name="precio" value="{{ $plato->precio }}">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
 
 
<div class="text-center mt-5">
    <a href="{{ route('carrito') }}" class="btn btn-success btn-lg">Ver carrito</a>
</div>
<script>
    const botones = document.querySelectorAll('.filter-btn');
    const platos = document.querySelectorAll('.plato');
 
    botones.forEach(btn => {
        btn.addEventListener('click', () => {
            const categoria = btn.getAttribute('data-categoria');
 
            platos.forEach(plato => {
                if(categoria.toLowerCase() === 'todos' || plato.dataset.categoria.toLowerCase() === categoria.toLowerCase()) {
                    plato.style.display = 'block';
                } else {
                    plato.style.display = 'none';
                }
            });
 
            botones.forEach(b => b.classList.remove('btn-primary'));
            botones.forEach(b => b.classList.add('btn-secondary'));
            btn.classList.add('btn-primary');
        });
    });
</script>
@endsection