@extends('layouts.app')

@section('titulo', 'Editar Diseño')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarDisenos">Administrar Diseños</a></li>
            <li class="breadcrumb-item active">Editar Diseño</li>
          </ol>

          <h2 class="section-title">Editar Diseño: {{$diseno->dsnCodigo}}</h2>
          <p class="section-subtitle">Ingrese los nuevos campos del punto de venta para modificarlos.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarDiseno">
                @csrf
                <input id="dsnID" type="hidden" name="dsnID" value="{{$diseno->dsnID}}" required>

                <div class="form-group row">
                    <label for="codigo" class="col-md-2 col-form-label text-md-right">Código *</label>

                    <div class="col-md-4">
                        <input id="codigo" type="text" class="form-control{{ Session::has('codigo') ? ' is-invalid' : '' }}" name="codigo" value="{{$diseno->dsnCodigo}}" required>

                        @if (Session::has('codigo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('codigo') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="descripcion" class="col-md-2 col-form-label text-md-right">Descripción *</label>

                    <div class="col-md-4">
                        <input id="descripcion" type="text" class="form-control{{ Session::has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{$diseno->dsnDescripcion}}" required>

                        @if (Session::has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>


                <div class="form-group row mb-0">
                    <div class="col-md-2 offset-md-10">
                      <br>
                      <button type="submit" class="btn btn-primary btn-block">
                          Guardar
                      </button>
                    </div>
                </div>

          </form>
          <hr>

        </div>
    </div>
</div>
@endsection
