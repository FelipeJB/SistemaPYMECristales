@extends('layouts.app')

@section('titulo', 'Programar Instalación')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Programar Instalación</li>
          </ol>

          <h2 class="section-title">Programar Instalación</h2>
          <p class="section-subtitle">Ingrese los datos para programar la instalación de la orden de venta {{$orden->ordID}}.</p><br>

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

          @if($orden->ordEstadoInstalacionID == 2)
              <div class="alert alert-dismissible alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading">Precaución!</h4>
                <strong><i class="fa fa-check"></i></strong> Esta orden aún no tiene todas sus medidas tomadas, ¿Seguro que desea programar la instalación?
              </div>
          @endif

          @if($orden->ordEstadoInstalacionID == 4)
              <div class="alert alert-dismissible alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4 class="alert-heading">Precaución!</h4>
                <strong><i class="fa fa-check"></i></strong> Esta orden ya tiene una instalación programada, ¿Seguro que desea reprogramarla?
              </div>
          @endif

          <form method="POST" action="/ProgramarInstalacionForm">
              @csrf
              <input id="ordID" type="hidden" name="ordID" value="{{$orden->ordID}}" required>

              <div class="form-group row">

                  <label for="fecha" class="col-md-2 col-form-label text-md-right">Fecha y Hora *</label>

                  <div class="col-md-4">
                      <input id="fecha" type="datetime-local" class="form-control{{ Session::has('fecha') ? ' is-invalid' : '' }}" name="fecha" value="{{ old('fecha') }}" required>

                      @if (Session::has('fecha'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('fecha') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="instalador" class="col-md-2 col-form-label text-md-right">Instalador *</label>

                  <div class="col-md-4">
                    <select class="form-control" id="instalador" name="instalador">
                      @foreach($instaladores as $i)
                        <option value="{{$i->insID}}">{{$i->insNombre}} {{$i->insApellido}}</option>
                      @endforeach
                    </select>
                  </div>

              </div>


              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-10">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block">
                        Registrar
                    </button>
                  </div>
              </div>

          </form>

          <hr>



        </div>
    </div>
</div>
@endsection
