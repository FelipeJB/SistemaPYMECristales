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

          <h2 class="section-title">Registrar Venta</h2>
          <p class="section-subtitle">Ingrese el número de documento del cliente para iniciar la venta.</p><br>

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

          <form method="POST" action="/RegistrarVenta">
              @csrf

              <div class="form-group row">

                  <label for="numero" class="col-md-4 col-form-label text-md-right">Número de documento *</label>

                  <div class="col-md-4">
                      <input id="numero" type="text" class="form-control{{ Session::has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{ old('numero') }}" required>

                      @if (Session::has('numero'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('numero') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="row justify-content-center">
                <span style="margin:2px 15px">Para registrar un cliente nuevo ingrese <a href="/RegistrarCliente">aquí.</a></span>
              </div>

              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-10">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block">
                        Continuar
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
                  <p class="badge badge-secondary" style="font-size:13px; margin:5px 8px">Seleccionar Cliente</p>
                  <p class="badge" style="font-size:13px; margin:5px 5px">Registrar Detalles</p>
                  <p class="badge" style="font-size:13px; margin:5px 5px">Confirmación</p>
                  <p class="badge" style="font-size:13px; margin:5px 5px">Registrar Orden</p>
              </center>
              </div>
            </div>
          </div>

        </div>
    </div>
</div>
@endsection
