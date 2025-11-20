@foreach($platos as $plato)
    <div class="card mb-3" style="width: 18rem;">
        <img src="{{ asset('storage/' . $plato->imagen) }}" class="card-img-top" alt="{{ $plato->nombre }}">
        <div class="card-body">
            <h5 class="card-title">{{ $plato->nombre }}</h5>
            <p class="card-text">S/ {{ number_format($plato->precio, 2) }}</p>
            <a href="{{ route('menu.show', $plato->id) }}" class="btn btn-primary">Ver detalle</a>
        </div>
    </div>
@endforeach