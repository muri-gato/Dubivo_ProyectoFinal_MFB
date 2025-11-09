<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- LOGO / Título -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400">
                    🎙️ Voice Market
                </a>
            </div>

            <!-- LINKS PRINCIPALES -->
            <div class="hidden sm:flex space-x-6 items-center">
                <a href="{{ url('/') }}" class="text-black-700 dark:text-gray-200 hover:text-indigo-600">Voces</a>
                <a href="{{ route('movies.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Obras</a>
                <a href="{{ route('schools.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Escuelas</a>

                @auth
                    <a href="{{ route('requests.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Solicitudes</a>
                @endauth
            </div>

            <!-- USUARIO -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-indigo-500 focus:outline-none transition">
                                {{ Auth::user()->name }}
                                <svg class="ms-1 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path fill="currentColor" d="M5.5 7l4.5 4 4.5-4" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Perfil') }}
                            </x-dropdown-link>
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
                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-gray-700 dark:text-gray-200 hover:text-indigo-600">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
