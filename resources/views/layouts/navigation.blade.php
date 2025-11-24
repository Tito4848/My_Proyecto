<nav x-data="{ open: false }" class="navbar-modern border-b border-gray-100 sticky-top" style="z-index: 1000;">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
             <!-- Logo -->
<div class="shrink-0 flex items-center">
    <a href="{{ route('inicio') }}" class="flex items-center gap-2">
        <img src="https://imgs.search.brave.com/btrMHuxlfUb36YR_434wHTkgfmtwIeoScOKqnlqAhB0/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/aWNvbnNjb3V0LmNv/bS9pY29uL2ZyZWUv/cG5nLTI1Ni9mcmVl/LXJlc3RhdXJhbnRl/LWljb24tc3ZnLWRv/d25sb2FkLXBuZy03/Mzc5MzQ3LnBuZz9m/PXdlYnAmdz0xMjg" 
             class="h-8 w-8" 
             alt="Logo">

        <span class="font-bold text-lg text-gray-700">
            Sal & Sabor
        </span>
    </a>
</div>


                <!-- Navigation Links (Left side) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex align-items-center">
                    <x-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')" class="d-flex align-items-center">
                        <i class="fas fa-home me-1"></i>{{ __('Inicio') }}
                    </x-nav-link>

                    <!-- Menú con Dropdown -->
                    <x-dropdown align="left" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 {{ request()->routeIs('menu') || request()->routeIs('delivery') || request()->routeIs('carrito') ? 'text-gray-900 bg-gray-50' : '' }}">
                                <i class="fas fa-utensils me-2"></i>
                                {{ __('Menú') }}
                                <svg class="ms-2 -me-0.5 h-4 w-4 transition-transform duration-200" 
                                     :class="{'rotate-180': open}" 
                                     xmlns="http://www.w3.org/2000/svg" 
                                     viewBox="0 0 20 20" 
                                     fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-1 py-1">
                                <x-dropdown-link :href="route('menu')" class="flex items-center group">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center me-3 group-hover:bg-blue-100 transition-colors">
                                        <i class="fas fa-utensils text-blue-600"></i>
                                    </div>
                                    <span class="flex-1 font-medium">{{ __('Ver Menú') }}</span>
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('delivery')" class="flex items-center group">
                                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center me-3 group-hover:bg-green-100 transition-colors">
                                        <i class="fas fa-truck text-green-600"></i>
                                    </div>
                                    <span class="flex-1 font-medium">{{ __('Delivery') }}</span>
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('carrito')" class="flex items-center group relative">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center me-3 group-hover:bg-red-100 transition-colors">
                                        <i class="fas fa-shopping-cart text-red-600"></i>
                                    </div>
                                    <span class="flex-1 font-medium">{{ __('Carrito') }}</span>
                                    @php
                                        $carritoCount = session('carrito') ? count(session('carrito')) : 0;
                                    @endphp
                                    @if($carritoCount > 0)
                                        <span class="badge bg-danger rounded-full ms-auto" style="font-size: 0.65rem; padding: 0.3rem 0.5rem; min-width: 22px; text-align: center; font-weight: 600;">
                                            {{ $carritoCount }}
                                        </span>
                                    @endif
                                </x-dropdown-link>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <x-nav-link :href="route('sobre-nosotros')" :active="request()->routeIs('sobre-nosotros')" class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-1"></i>{{ __('Sobre Nosotros') }}
                    </x-nav-link>

                    <x-nav-link :href="route('contacto')" :active="request()->routeIs('contacto')" class="d-flex align-items-center">
                        <i class="fas fa-envelope me-1"></i>{{ __('Contacto') }}
                    </x-nav-link>

                    <x-nav-link :href="route('reserva')" :active="request()->routeIs('reserva')" class="d-flex align-items-center">
                        <i class="fas fa-calendar-check me-1"></i>{{ __('Reservas') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings / Admin / Auth Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- Carrito con contador -->
                <a href="{{ route('carrito') }}" class="relative inline-flex items-center px-3 py-2 text-gray-600 hover:text-gray-800 transition ease-in-out duration-150">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    @php
                        $carritoCount = session('carrito') ? count(session('carrito')) : 0;
                    @endphp
                    @if($carritoCount > 0)
                        <span class="absolute -top-1 -right-1 bg-danger text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
                            {{ $carritoCount }}
                        </span>
                    @endif
                </a>

                @auth

                    {{-- 🔥 PANEL ADMIN SOLO SI ES ADMIN --}}
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-gray-600 hover:text-gray-800 px-3 mr-3">
                            Panel Administrador
                        </a>
                    @endif

                    <!-- Dropdown con nombre de usuario y avatar -->
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="rounded-full me-2" 
                                         style="width: 32px; height: 32px; object-fit: cover;">
                                @else
                                    <div class="rounded-full me-2 bg-gradient-primary text-white d-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <x-dropdown-link :href="route('perfil')" class="flex items-center">
                                <i class="fas fa-user me-3 text-primary" style="width: 20px;"></i>
                                <span>{{ __('Mi Perfil') }}</span>
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('mis-compras')" class="flex items-center">
                                <i class="fas fa-history me-3 text-info" style="width: 20px;"></i>
                                <span>{{ __('Mis Compras') }}</span>
</x-dropdown-link>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();"
                                                 class="flex items-center text-danger">
                                    <i class="fas fa-sign-out-alt me-3" style="width: 20px;"></i>
                                    <span>{{ __('Cerrar sesión') }}</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Si no está logueado -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 px-3">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800 px-3">Registrarse</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')">
                <i class="fas fa-home me-2"></i>{{ __('Inicio') }}
            </x-responsive-nav-link>

            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                Menú
            </div>

            <x-responsive-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                <i class="fas fa-utensils me-2"></i>{{ __('Ver Menú') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('delivery')" :active="request()->routeIs('delivery')">
                <i class="fas fa-truck me-2"></i>{{ __('Delivery') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('carrito')" :active="request()->routeIs('carrito')">
                <i class="fas fa-shopping-cart me-2"></i>{{ __('Carrito') }}
                @php
                    $carritoCount = session('carrito') ? count(session('carrito')) : 0;
                @endphp
                @if($carritoCount > 0)
                    <span class="badge bg-danger rounded-pill ms-2">{{ $carritoCount }}</span>
                @endif
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('sobre-nosotros')" :active="request()->routeIs('sobre-nosotros')">
                <i class="fas fa-info-circle me-2"></i>{{ __('Sobre Nosotros') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contacto')" :active="request()->routeIs('contacto')">
                <i class="fas fa-envelope me-2"></i>{{ __('Contacto') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reserva')" :active="request()->routeIs('reserva')">
                <i class="fas fa-calendar-check me-2"></i>{{ __('Reservas') }}
            </x-responsive-nav-link>

            {{-- 🔥 PANEL ADMIN EN RESPONSIVE --}}
            @auth
                @if(auth()->user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')">
                        {{ __('Panel Administrador') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Auth Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                


                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Iniciar sesión') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Registrarse') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>        