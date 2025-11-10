<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurante Sal & Sabor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff5f0;
            font-family: 'Segoe UI', sans-serif;
        }
        nav {
            background-color: #8b4513;
        }
        nav a {
            color: white !important;
        }
        footer {
            background: #8b4513;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
        .hero {
            background: url('https://images.unsplash.com/photo-1565299624946-b28f40a0ae38') center/cover;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
        }
        input.form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        input.form-control:focus {
            border-color: #b22222;
            box-shadow: 0 0 4px rgba(178, 34, 34, 0.3);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark px-4">
  <a class="navbar-brand" href="/">Sal & Sabor</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
      <li class="nav-item"><a class="nav-link" href="/">Inicio</a></li>
      <li class="nav-item"><a class="nav-link" href="/menu">Menú</a></li>
      <li class="nav-item"><a class="nav-link" href="/reserva">Reservar</a></li>
      <li class="nav-item"><a class="nav-link" href="/contacto">Contacto</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('carrito') }}">Carrito</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<footer>
    <p>© 2025 Sal & Sabor - Todos los derechos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
