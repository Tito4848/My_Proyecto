@extends('layouts.app')

@section('title', 'Inicio | Sal & Sabor')

@section('content')

<style>
    /* Colores estilo Figma */
    .soft-pink { background: #fde7e7; }
    .soft-pink-2 { background: #ffefef; }
    .btn-red { background: #d62828; color: white; }
    .btn-red:hover { background: #b71f1f; }

    .hero-img {
        max-height: 500px;
        object-fit: cover;
        width: 100%;
    }

    .section-title {
        font-weight: bold;
        letter-spacing: 1px;
        color: #d62828;
    }

    /* Overlay del carrusel */
    .carousel-caption {
        background: rgba(0,0,0,0.4);
        padding: 1rem 1.5rem;
        border-radius: 8px;
    }
</style>

<!-- =========================
      HERO PRINCIPAL CON CARRUSEL
========================= -->
<section class="text-center bg-white py-4">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner rounded shadow-lg">

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

    <!-- Botones -->
    <div class="py-4">
        <a href="{{ route('menu') }}" class="btn btn-red mx-2 px-4">Nuestro menú →</a>
        <a href="{{ route('reserva') }}" class="btn btn-outline-danger mx-2 px-4">Reservar mesa →</a>
    </div>

    <p class="fs-5 mt-3 px-3">
        Creemos en los placeres sencillos de la vida.<br>
        Buena comida, ingredientes frescos y buena vibra.<br>
        Bienvenido a Sal & Sabor, siéntete como en casa.
    </p>
</section>

<!-- =========================
  SECCIÓN FAVORITA DE LOS FANS
========================= -->
<section class="soft-pink py-5">
    <div class="container">
        <div class="row align-items-center">

            <!-- Imagen -->
            <div class="col-md-6">
                <img src="https://imgs.search.brave.com/IX5setiUn6Pmm_6X8I0AT6ITzfemJeZcTK2gY5xzGXQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly93d3cu/ZWF0cGVydS5jb20v/d3AtY29udGVudC91/cGxvYWRzLzIwMTkv/MTAvcG9sbG8tYS1s/YS1icmFzYS13aXRo/LXNhbGFkLWFuZC1k/aXBwaW5nLXNhdWNl/cy5qcGc"
                     class="img-fluid rounded shadow">
            </div>

            <!-- Texto -->
            <div class="col-md-6">
                <h3 class="section-title">La favorita de los fans</h3>
                <h2 class="fw-bold mb-3">Pollo a la Brasa</h2>
                <p>
                    El Pollo a la Brasa es un clásico peruano, jugoso, dorado y lleno de sabor.
                    Servido con papas fritas, ensalada y el toque único de Sal & Sabor.
                </p>
                <a href="{{ route('menu') }}" class="btn btn-red px-4">Ver más</a>
            </div>

        </div>
    </div>
</section>

<!-- =========================
  OFERTA DEL DÍA
========================= -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <!-- Texto -->
            <div class="col-md-6 soft-pink-2 p-4 rounded shadow">
                <h3 class="section-title">Oferta del Día</h3>
                <p>
                    ¡Disfruta nuestro menú especial con sabores frescos y deliciosos!
                    Cada día una opción diferente para sorprender tu paladar.
                </p>
                <a href="{{ route('menu') }}" class="btn btn-red px-4">Pedir</a>
            </div>

            <!-- Imagen -->
            <div class="col-md-6 mt-3 mt-md-0">
                <img src="https://imgs.search.brave.com/8IJ5H5asWfivMzgxmAilxtAxTR32urnOh3c-jscMrRU/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90My5m/dGNkbi5uZXQvanBn/LzEyLzM5LzMyLzcw/LzM2MF9GXzEyMzkz/MjcwODdfSUVRM3VH/bDhETXdQY1BUTHFp/QmdMeFd0b0lleU1k/aWEuanBn"
                     class="img-fluid rounded shadow">
            </div>

        </div>
    </div>
</section>

<!-- =========================
      RESERVA UNA MESA
========================= -->
<section class="soft-pink py-5">
    <div class="container">

        <div class="row justify-content-center align-items-center">

            <!-- Formulario -->
            <div class="col-md-5 p-4 bg-white rounded shadow">
                <h3 class="section-title mb-3">Reserva una mesa</h3>

                <form>
                    <div class="mb-3">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" placeholder="Tu nombre">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control" placeholder="987654321">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Personas</label>
                        <select class="form-select">
                            <option>1 Persona</option>
                            <option>2 Personas</option>
                            <option>3 Personas</option>
                            <option>4+ Personas</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-red w-100">Reservar</button>
                </form>
            </div>

            <!-- Imagen derecha -->
            <div class="col-md-5 mt-4 mt-md-0">
                <img src="https://imgs.search.brave.com/itHaBVCKJddopkW5LqYWQEWSwD2sTrpp67vutqYf0AQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzE0LzU1LzQ1LzM3/LzM2MF9GXzE0NTU0/NTM3NTlfbnBCdnpx/MllWTm5ncENJNXRl/STVUV0FuWGp3azNw/WjIuanBn"
                     class="img-fluid rounded shadow">
            </div>

        </div>

    </div>
</section>

@endsection
