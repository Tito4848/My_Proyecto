<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('inicio') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (Left side) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    <x-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                        {{ __('Menú') }}
                    </x-nav-link>

                    <x-nav-link :href="route('contacto')" :active="request()->routeIs('contacto')">
                        {{ __('Contacto') }}
                    </x-nav-link>

                    <x-nav-link :href="route('reserva')" :active="request()->routeIs('reserva')">
                        {{ __('Reservas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('delivery')" :active="request()->routeIs('delivery')">
                        {{ __('Delivery') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings / Admin / Auth Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth

                    {{-- 🔥 PANEL ADMIN SOLO SI ES ADMIN --}}
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-gray-600 hover:text-gray-800 px-3 mr-3">
                            Panel Administrador
                        </a>
                    @endif

                    <!-- Dropdown con nombre de usuario -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('perfil')">
    {{ __('Perfil') }}
</x-dropdown-link>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
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
                {{ __('Inicio') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                {{ __('Menú') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contacto')" :active="request()->routeIs('contacto')">
                {{ __('Contacto') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reserva')" :active="request()->routeIs('reserva')">
                {{ __('Reservas') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('delivery')" :active="request()->routeIs('delivery')">
                {{ __('Delivery') }}
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
