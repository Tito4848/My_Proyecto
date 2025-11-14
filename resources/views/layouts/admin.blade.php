<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Panel Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="bg-dark text-white p-3" style="width: 250px; min-height: 100vh;">
            <h4 class="mb-4">Admin</h4>

            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.platos.index') }}" class="nav-link text-white">Platos</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.pedidos.index') }}" class="nav-link text-white">Pedidos</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.usuarios.index') }}" class="nav-link text-white">Usuarios</a>
                </li>
                <li class="mt-4 px-4">
                    <a href="{{ route('inicio') }}"
                        class="block px-3 py-2 rounded bg-gray-700 text-gray-200 hover:bg-gray-600">
                        ← Volver al Inicio
                    </a>
                </li>



            </ul>
        </div>

        <!-- Contenido -->
        <div class="p-4 flex-grow-1">
            @yield('content')
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>