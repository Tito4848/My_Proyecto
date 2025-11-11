@extends('layouts.app')

@section('title', 'Inicio | Sal & Sabor')

@section('content')
<!-- Hero principal -->
<div class="hero text-center bg-light py-5">
    <h1 class="display-4 fw-bold text-danger">Bienvenido a Sal & Sabor</h1>
    <p class="fs-5 text-muted">Descubre los sabores auténticos del Perú 🇵🇪</p>
</div>

<!-- Carrusel de imágenes -->
<div id="carouselPlatos" class="carousel slide my-5" data-bs-ride="carousel">
  <div class="carousel-inner rounded shadow-lg">
    <div class="carousel-item active">
      <img src="https://imgs.search.brave.com/KCq-_oHKjtUtA1iOuiS974257Nlxk-ojnzoR3rDOQ-c/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzA5Lzg3Lzk0LzE1/LzM2MF9GXzk4Nzk0/MTU0N19sUlNKTDVZ/amc0RWh0S3dVVmxO/SHFiQVlibzZmY2FD/WS5qcGc" class="d-block w-100" alt="Ceviche peruano">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2">
        <h5>Ceviche Peruano</h5>
        <p>El plato bandera del Perú, fresco y lleno de sabor.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://imgs.search.brave.com/eNQq8S_0uTC8ifuqsGEo9_f7Lo42oHpwyV908eU-1AM/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzA5LzY5LzI2Lzcy/LzM2MF9GXzk2OTI2/NzIyMF95amVQYnhy/Z1pRZnB1a2xMdDRO/bk50TkR3U0lsaHpE/MS5qcGc" class="d-block w-100" alt="Lomo Saltado">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2">
        <h5>Lomo Saltado</h5>
        <p>Jugoso, sabroso y acompañado de papas fritas caseras.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://imgs.search.brave.com/itHaBVCKJddopkW5LqYWQEWSwD2sTrpp67vutqYf0AQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzE0LzU1LzQ1LzM3/LzM2MF9GXzE0NTU0/NTM3NTlfbnBCdnpx/MllWTm5ncENJNXRl/STVUV0FuWGp3azNw/WjIuanBn" class="d-block w-100" alt="Aji de Gallina">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2">
        <h5>Ají de Gallina</h5>
        <p>Una mezcla cremosa y deliciosa que conquista paladares.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://imgs.search.brave.com/8IJ5H5asWfivMzgxmAilxtAxTR32urnOh3c-jscMrRU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzEyLzM5LzMyLzcw/LzM2MF9GXzEyMzkz/MjcwODdfSUVRM3VH/bDhETXdQY1BUTHFp/QmdMeFd0b0lleU1k/aWEuanBn" class="d-block w-100" alt="Arroz con Mariscos">
      <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2">
        <h5>Arroz con Mariscos</h5>
        <p>El sabor del mar en un solo plato.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselPlatos" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselPlatos" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Texto de bienvenida -->
<div class="text-center my-5">
  <p class="fs-5">Creemos en los placeres sencillos de la vida.<br>
  Buena comida, ingredientes frescos y buena vibra.<br>
  Siéntete como en casa.</p>

  <a href="{{ route('menu') }}" class="btn btn-danger m-2">Ver menú</a>
  <a href="{{ route('reserva') }}" class="btn btn-outline-danger m-2">Reservar mesa</a>
</div>

<!-- Sección de plato destacado -->
<div class="row my-4 align-items-center">
  <div class="col-md-6">
    <img src="https://imgs.search.brave.com/IX5setiUn6Pmm_6X8I0AT6ITzfemJeZcTK2gY5xzGXQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/ZWF0cGVydS5jb20v/d3AtY29udGVudC91/cGxvYWRzLzIwMTkv/MTAvcG9sbG8tYS1s/YS1icmFzYS13aXRo/LXNhbGFkLWFuZC1k/aXBwaW5nLXNhdWNl/cy5qcGc" class="img-fluid rounded shadow" alt="Pollo a la brasa">
  </div>
  <div class="col-md-6 d-flex flex-column justify-content-center">
    <h3 class="text-danger fw-bold">La favorita de los fans: Pollo a la Brasa</h3>
    <p>Preparado al estilo peruano con papas doradas y ají especial. ¡Pide el tuyo ahora!</p>
    <a href="{{ route('menu') }}" class="btn btn-danger w-50">Ver más</a>
  </div>
</div>
@endsection
