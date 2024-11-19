<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        <nav class="bg-white shadow-sm">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Brand -->
                    <a class="text-lg font-semibold text-gray-700 hover:text-gray-900" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <!-- Navbar Toggler for Mobile (Optional) -->
                    <div class="block lg:hidden">
                        <button id="navbar-toggler" class="text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Navbar Links -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-4" id="navbar-menu">
                        <ul class="flex space-x-4">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li>
                                        <a class="text-gray-700 hover:text-gray-900" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li>
                                        <a class="text-gray-700 hover:text-gray-900" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="relative">
                                    <button class="text-gray-700 hover:text-gray-900 focus:outline-none" onclick="toggleDropdown()">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden">
                                        <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            @yield('content')
        </main>
    </div>

    <!-- Tailwind CSS Dropdown Toggle Script -->
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }

        // Optional: Navbar Toggle for Mobile View
        document.getElementById('navbar-toggler').addEventListener('click', function() {
            const navbarMenu = document.getElementById('navbar-menu');
            navbarMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
