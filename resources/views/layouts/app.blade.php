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
                    <img class="text-light" src="" alt="Logo">
                </div>
                <div>
                    @guest
                        <a class="nav-link text-light" href="{{ route('login') }}">
                            <i class="bi bi-door-closed"></i> Identificarse
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-people-fill me-2"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li>
                                    <a href="{{ config('app.url') }}/cuenta" class="dropdown-item">Mi cuenta</a>
                                </li>
                                <li>
                                    <a href="{{ route('reservas') }}" class="dropdown-item">Mis reservas</a>
                                </li>
                            </ul>
                        </div>
                    @endguest

                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
        
    </main>
</body>

</html>