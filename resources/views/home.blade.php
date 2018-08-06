@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">Inicio</li>
          </ol>
          <div class="jumbotron">
            <h2>Bienvenido/a {{ Auth::user()->usrNombre }}</h2>
            <p>A continuación se listan las posibles acciones que puede realizar.</p><br>

            @if(Auth::user()->usrRolID == 1)
              <h3>Usuarios</h3>
              <ul>
                <li><a href="/AdministrarUsuarios">Administrar Usuarios</a></li>
                <li><a href="/RegistrarUsuario">Registrar Usuario</a></li>
              </ul>
              <h3>Productos</h3>
              <ul>
                <li><a href="/AdministrarProductos">Administrar Productos</a></li>
                <li><a href="/CrearProducto">Crear Producto</a></li>
              </ul>
              <h3>Puntos de Venta</h3>
              <ul>
                <li><a href="/AdministrarPuntos">Administrar Puntos de Venta</a></li>
                <li><a href="/CrearPunto">Crear Punto de Venta</a></li>
              </ul>
              <h3>Instaladores</h3>
              <ul>
                <li><a href="/AdministrarInstaladores">Administrar Instaladores</a></li>
                <li><a href="/CrearInstalador">Crear Instalador</a></li>
              </ul>
              <h3>Datos</h3>
              <ul>
                <li><a href="/MigrarDatos">Migrar Datos</a></li>
              </ul>
            @endif

          </div>
        </div>
    </div>
</div>
@endsection
