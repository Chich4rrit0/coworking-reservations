<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Coworking Reservations') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f8f9fa;
            }
            .hero {
                background-color: #343a40;
                color: white;
                padding: 100px 0;
                margin-bottom: 50px;
            }
            .card {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: none;
                margin-bottom: 20px;
                transition: transform 0.3s ease;
            }
            .card:hover {
                transform: translateY(-5px);
            }
            .btn-primary {
                background-color: #3490dc;
                border-color: #3490dc;
            }
            .btn-primary:hover {
                background-color: #2779bd;
                border-color: #2779bd;
            }
            .footer {
                background-color: #343a40;
                color: white;
                padding: 20px 0;
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Coworking Reservations') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item">
                                    <a href="{{ url('/home') }}" class="nav-link">Home</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link">Log in</a>
                                </li>

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <section class="hero text-center">
            <div class="container">
                <h1 class="display-4">Sistema de Reservas de Coworking</h1>
                <p class="lead">Reserva tu espacio de trabajo de manera fácil y rápida</p>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-primary btn-lg">Ir al Dashboard</a>
                    @else
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Iniciar Sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Registrarse</a>
                            @endif
                        </div>
                    @endauth
                @endif
            </div>
        </section>

        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-12">
                    <h2>Nuestros Servicios</h2>
                    <p class="lead">Ofrecemos espacios de trabajo flexibles para profesionales y empresas</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h3 class="card-title">Salas de Reuniones</h3>
                            <p class="card-text">Espacios equipados para reuniones profesionales y presentaciones.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h3 class="card-title">Oficinas Privadas</h3>
                            <p class="card-text">Espacios individuales para trabajar con privacidad y concentración.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h3 class="card-title">Espacios Colaborativos</h3>
                            <p class="card-text">Áreas abiertas para networking y trabajo en equipo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer text-center">
            <div class="container">
                <p class="mb-0">&copy; {{ date('Y') }} Coworking Reservations. Todos los derechos reservados.</p>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>