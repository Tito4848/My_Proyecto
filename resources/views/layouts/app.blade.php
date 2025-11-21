<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Sal & Sabor'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts - Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased" style="font-family: 'Poppins', sans-serif;">
    <div class="min-h-screen bg-gray-50">

        @include('layouts.navigation')

        <main class="py-4 animate-fade-in">
            @yield('content')
        </main>

        <footer class="footer-modern text-white py-8 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <h5 class="mb-3"><i class="fas fa-utensils me-2"></i>Sal & Sabor</h5>
                        <p class="mb-0 text-muted">Sabores auténticos del Perú en cada bocado</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="mb-3">
                            <a href="#" class="text-white me-3 hover-scale" style="font-size: 1.5rem;"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="text-white me-3 hover-scale" style="font-size: 1.5rem;"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white hover-scale" style="font-size: 1.5rem;"><i class="fab fa-whatsapp"></i></a>
                        </div>
                        <small class="text-muted">© {{ date('Y') }} Sal & Sabor — Todos los derechos reservados.</small>
            </div>
        </div>
    </div>
</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
