<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <header>
        <nav class="navbar bg-black">
            <div class="container-xl p-3">
                <div>
                    <a href="{{ url('/') }}">
                        <img class="text-light w-75" src="{{ asset('storage/logo.webp') }}" alt="Logo">
                    </a>
                </div>
                <div>
                   
                        <a class="nav-link text-light" href="{{ route('login') }}">
                            <i class="bi bi-door-closed"></i> Identificarse
                        </a>
                    
                      

                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')

    </main>
    <footer class="bg-black text-light p-3">
        <div class="d-flex flex-row justify-content-evenly">
            <div class="d-flex flex-column align-items-center">
                <i class="bi bi-calendar-date"></i>
                Reserva
            </div>
            <div class="d-flex flex-column align-items-center">
                <a href="https://maps.app.goo.gl/Cy26WeuxhQJhYfpS7" class="text-decoration-none text-light">
                    <i class="bi bi-geo-alt"></i>
                </a>
                Info
            </div>
            <div class="d-flex flex-column align-items-center">
                <i class="bi bi-image"></i>
                Galería
            </div>
            <div class="d-flex flex-column align-items-center">
                <i class="bi bi-star"></i>
                Reseñas
            </div>
        </div>
    </footer>
</body>

</html>