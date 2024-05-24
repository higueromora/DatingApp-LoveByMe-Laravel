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
    
    

    <!-- Introducimos la carpeta css que metemos en vite para maquetación manual -->
    <!-- Scripts -->
    @vite(['resources/sass/app.scss','resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md  navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <p>L<img src="{{ asset('img/Logo.svg') }}" width="25px" alt="">ByMe</p>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">Gente</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('like.index') }}">Favoritos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('matches.indexmatch') }}">Matches</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('image.create') }}">Subir Imagen</a>
                            </li>
                            <li>
                                @include('includes.avatar')
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile', ['id'=>Auth::user()->id])}}">
                                        Mi perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('config')}} ">
                                        Configuración
                                    </a>
                                    <a class="dropdown-item" href="{{ route('user.blocked') }}">
                                        Usuarios bloqueados
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class=" text-center text-lg-start footer">
        <!-- Icons section -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <div class="d-flex justify-content-center">
            <a href="https://github.com/higueromora" class="me-4 text-reset">
                <img src="{{ asset('img/SimpleIconsFacebook.svg') }}">
            </a>
            <a href="https://github.com/higueromora" class="me-4 text-reset">
                <img src="{{ asset('img/SimpleIconsTiktok.svg') }}">
            </a>
            <a href="https://github.com/higueromora" class="me-4 text-reset">
                <img src="{{ asset('img/SkillIconsInstagram.svg') }}">
            </a>
            <a href="https://github.com/higueromora" class="me-4 text-reset">
                <img src="{{ asset('img/RiTwitterXLine.svg') }}">
            </a>
            <a href="https://github.com/higueromora" class="me-4 text-reset">
                <img src="{{ asset('img/SkillIconsLinkedin.svg') }}">
            </a>
            </div>
        </div>
        <!-- Icons section -->
        
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <span class="fw-bold">LoveByMe</span>
            <p >Conecta con personas y crea nuevas experiencias. Encuentra tu match perfecto con nuestra innovadora plataforma</p>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2024 Copyright:
            <a class="text-body" href="https://github.com/higueromora">LoveByMe</a>
        </div>
        <!-- Copyright -->
        </footer>
        <!-- Footer -->


    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        window.PUSHER_APP_KEY = "{{ env('PUSHER_APP_KEY') }}";
        window.PUSHER_APP_CLUSTER = "{{ env('PUSHER_APP_CLUSTER') }}";
    </script>

</body>
</html>
