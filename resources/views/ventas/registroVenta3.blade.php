@extends('layouts.app')

@section('titulo', 'Registrar Venta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Registrar Venta</li>
          </ol>

          <h2 class="section-title">Registrar Detalle de Venta {{count($detalles)+1}}</h2>
          <p class="section-subtitle">Ingrese los datos del detalle número {{count($detalles)+1}} de la orden de venta.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

          @if(Session::has('success'))
              <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('success') !!}
              </div>
          @endif

          <form method="POST" action="/CrearDetalle">
              @csrf



              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-8">
                    <br>
                    <button type="submit" name="action" value="continue" class="btn btn-primary btn-block">
                        Nuevo Detalle
                    </button>
                  </div>
                  <div class="col-md-2">
                    <br>
                    <button type="submit" name="action" value="finish" class="btn btn-success btn-block">
                        Finalizar
                    </button>
                  </div>
              </div>

          </form>

          <hr>
          <div class="row justify-content-center" style="margin-top:25px;">
            <div class="col-md-6">
              <center>
                <h3>Progreso</h3>
              </center>
              <div class="alert alert-light">
                <center>
                <p class="badge badge-success" style="font-size:13px; margin:5px 8px">Seleccionar Cliente</p>
                <p class="badge badge-success" style="font-size:13px; margin:5px 5px">Registrar Orden</p>
                <p class="badge badge-secondary" style="font-size:13px; margin:5px 5px">Registrar Detalles</p>
                <p class="badge" style="font-size:13px; margin:5px 5px">Resumen</p>
              </center>
              </div>
            </div>
          </div>


        </div>
    </div>
</div>
@endsection
