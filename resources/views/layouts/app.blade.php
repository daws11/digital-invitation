<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('digital Wedding', 'Digital Wedding') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/811cf44b8d.js" crossorigin="anonymous"></script>

    <style>
        /* Layout Optimization for Mobile */
        body {
            max-width: 768px;
            margin: 0 auto;
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div id="app">
        <!-- Main Content -->
        <main class="pb-20"> <!-- Extra space for navbar -->
            @yield('content')
        </main>

        <!-- Include Navbar -->
        @unless(Route::currentRouteName() === 'login')
            @include('components.navbar')
        @endunless

    </div>
</body>
</html>


