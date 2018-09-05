@extends('layouts.app')

@section('titulo', 'Editar Elemento')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarSistemas">Administrar Sistemas</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarSistemas/Elementos/{{$sistema->stmID}}">Elementos de Sistema</a></li>
            <li class="breadcrumb-item active">Editar Elemento</li>
          </ol>

          <h2 class="section-title">Editar Elemento: {{$elemento->stmdDescripcion}}</h2>
          <p class="section-subtitle">Ingrese los nuevos campos del elemento para modificarlos.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarElemento">
                @csrf
                <input id="stmdID" type="hidden" name="stmdID" value="{{$elemento->stmdID}}" required>

                <div class="form-group row">

                    <label for="sistema" class="col-md-2 col-form-label text-md-right">Sistema </label>

                    <div class="col-md-4">
                        <input id="sistema" type="text" class="form-control{{ Session::has('sistema') ? ' is-invalid' : '' }}" name="sistema" value="{{$sistema->stmDescripcion}}" disabled>

                        @if (Session::has('sistema'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('sistema') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="descripcion" class="col-md-2 col-form-label text-md-right">Descripción *</label>

                    <div class="col-md-4">
                        <input id="descripcion" type="text" class="form-control{{ Session::has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{$elemento->stmdDescripcion}}" required>

                        @if (Session::has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group row">

                    <label for="cantidad" class="col-md-2 col-form-label text-md-right">Cantidad*</label>

                    <div class="col-md-4">
                        <input id="cantidad" type="text" class="form-control{{ Session::has('cantidad') ? ' is-invalid' : '' }}" name="cantidad" value="{{$elemento->stmdCantidad}}" required>

                        @if (Session::has('cantidad'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('cantidad') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="codigo" class="col-md-2 col-form-label text-md-right">Código World Office*</label>

                    <div class="col-md-4">
                        <input id="codigo" type="text" class="form-control{{ Session::has('codigo') ? ' is-invalid' : '' }}" name="codigo" value="{{$elemento->stmdCodigoWO}}" required>

                        @if (Session::has('codigo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('codigo') }}</strong>
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
