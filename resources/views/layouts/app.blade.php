<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('titulo')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <img src="{{ URL::asset('img/Logo-mid.png') }}" width="40" style="margin-right:10px">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/">Inicio</a>
                            </li>
                            @if(Auth::user()->usrRolID == 1)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownUsersAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Usuarios <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUsersAdmin">
                                    <a class="dropdown-item" href="/AdministrarUsuarios">Administrar Usuarios</a>
                                    <a class="dropdown-item" href="/RegistrarUsuario">Registrar Usuario</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownProductsAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Productos <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProductsAdmin">
                                  <a class="dropdown-item" href="/AdministrarDisenos">Administrar Diseños</a>
                                  <a class="dropdown-item" href="/AdministrarMilimetrajes">Administrar Milimetrajes</a>
                                  <a class="dropdown-item" href="/AdministrarColores">Administrar Colores</a>
                                  <a class="dropdown-item" href="/AdministrarSistemas">Administrar Sistemas</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownVidriosAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Vidrios <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProductsVidrios">
                                  <a class="dropdown-item" href="/AdministrarPrecios">Administrar Precios</a>
                                  <a class="dropdown-item" href="/AdministrarCodigos">Administrar Códigos</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownPuntosAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Puntos de Venta <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPuntosAdmin">
                                    <a class="dropdown-item" href="/AdministrarPuntos">Administrar Puntos de Venta</a>
                                    <a class="dropdown-item" href="/CrearPunto">Crear Punto de Venta</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownInstaladoresAdmin" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Instaladores <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPuntosAdmin">
                                    <a class="dropdown-item" href="/AdministrarInstaladores">Administrar Instaladores</a>
                                    <a class="dropdown-item" href="/CrearInstalador">Crear Instalador</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/MigrarDatos">Migrar Datos</a>
                            </li>
                            @endif

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->usrNombre }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="/EditarClave">Cambiar Contraseña</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
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
    </div>
</body>
</html>
