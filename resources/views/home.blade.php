@extends('layouts.app')

@section('titulo', 'Inicio')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">Inicio</li>
          </ol>

          @if(Session::has('success'))
              <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('success') !!}
              </div>
          @endif

          <div class="jumbotron">
            <h2>Bienvenido/a {{ Auth::user()->usrNombre }}</h2>
            <p>A continuación se listan las posibles acciones que puede realizar.</p><br>

            @if(Auth::user()->usrRolID == 1)
              <div class="row">
                <div class="col-md-4">
                  <h3>Usuarios</h3>
                  <ul>
                    <li><a href="/AdministrarUsuarios">Administrar Usuarios</a></li>
                    <li><a href="/RegistrarUsuario">Registrar Usuario</a></li>
                  </ul>
                  <h3>Productos</h3>
                  <ul>
                    <li><a href="/AdministrarDisenos">Administrar Diseños</a></li>
                    <li><a href="/AdministrarMilimetrajes">Administrar Milimetrajes</a></li>
                    <li><a href="/AdministrarColores">Administrar Colores</a></li>
                    <li><a href="/AdministrarSistemas">Administrar Sistemas</a></li>
                  </ul>
                </div>
                <div class="col-md-4">
                  <h3>Vidrios</h3>
                  <ul>
                    <li><a href="/AdministrarPrecios">Administrar Precios</a></li>
                    <li><a href="/AdministrarCodigos">Administrar Códigos</a></li>
                  </ul>
                  <h3>Puntos de Venta</h3>
                  <ul>
                    <li><a href="/AdministrarPuntos">Administrar Puntos de Venta</a></li>
                    <li><a href="/CrearPunto">Crear Punto de Venta</a></li>
                  </ul>
                </div>
                <div class="col-md-4">
                  <h3>Instaladores</h3>
                  <ul>
                    <li><a href="/AdministrarInstaladores">Administrar Instaladores</a></li>
                    <li><a href="/CrearInstalador">Crear Instalador</a></li>
                  </ul>
                  <h3>Datos</h3>
                  <ul>
                    <li><a href="/MigrarDatos">Migrar Datos</a></li>
                  </ul>
                </div>
              </div>
            @endif

            @if(Auth::user()->usrRolID == 2)
              <div class="row">
                <div class="col-md-4">
                  <h3>Ventas</h3>
                  <ul>
                    <li><a href="/RegistrarVenta">Registrar Venta</a></li>
                    <li><a href="/Ventas">Ver Ventas</a></li>
                    <li><a href="/ConsultarVenta">Consultar estado de Venta</a></li>
                    <li><a href="/GenerarInformeVenta">Generar informe de Venta</a></li>
                  </ul>
                  <h3>Garantías</h3>
                  <ul>
                    <li><a href="/RegistrarGarantia">Registrar Garantía</a></li>
                    <li><a href="/ConsultarGarantia">Consultar documento de Garantía</a></li>
                  </ul>
                </div>
              </div>
            @endif
            @if(Auth::user()->usrRolID == 3)
              <div class="row">
                <div class="col-md-4">
                  <h3>Medidas</h3>
                  <ul>
                    <li><a href="/RegistrarMedidas">Tomar Medidas</a></li>
                    <li><a href="/GenerarPlanosMedidas">Generar planos de Medidas</a></li>
                  </ul>
                  <h3>Ventas</h3>
                  <ul>
                    <li><a href="/Ventas">Ver Ventas</a></li>
                    <li><a href="/GenerarInformeVenta">Generar informe de Venta</a></li>
                  </ul>
                </div>
              </div>
            @endif

          </div>
        </div>
    </div>
</div>
@endsection
