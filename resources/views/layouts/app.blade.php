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
    <!-- CSS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar bg-black">
            <div class="container-xl p-3">
                <div>
                    <a href="{{ url('/') }}">
                        <img class="text-light w-75" src="{{ asset('storage/logo.webp') }}" alt="Logo">
                    </a>
                </div>
                <div>
                    @guest
                        <a class="nav-link text-light" href="{{ route('login') }}">
                            <i class="bi bi-door-closed"></i> Identificarse
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="text-light dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-people-fill me-2"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li>
                                    <a href="{{ config('app.url') }}/cuenta" class="dropdown-item bg-light text-black">Mi
                                        cuenta</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item bg-light text-black">{{ __('Cerrar sesión') }}</button>
                                    </form>
                                </li>

                            </ul>
                        </div>
                    @endguest


                </div>
            </div>
        </nav>
    </header>
    <main class="@yield('main-class') flex-grow-1 main d-flex justify-content-center flex-column">

        @hasSection('homepage')

            @yield('homepage')

        @else

            <div class="d-flex justify-content-center align-items-center @yield('class-style')" >
                <div class="@yield('class-style') bg-black p-5 rounded-4 text-light my-5 my-md-0 "
                    style="@yield('card-style')">
                    @yield('content')
                </div>
            </div>

        @endif

    </main>
    <footer class="bg-black text-light p-3">
        <div class="d-flex flex-row justify-content-evenly">
            <div class="d-flex flex-column align-items-center">
                <a href="{{ route('reservar') }}" class="text-decoration-none text-light">

                    <i class="bi bi-calendar-date"></i>
                </a>
                Reserva
            </div>
            <div class="d-flex flex-column align-items-center">
                <a href="https://maps.app.goo.gl/Cy26WeuxhQJhYfpS7" target="blank"
                    class="text-decoration-none text-light">
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