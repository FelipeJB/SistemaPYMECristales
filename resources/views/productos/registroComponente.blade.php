@extends('layouts.app')

@section('titulo', 'Agregar Elemento')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarSistemas">Administrar Sistemas</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarSistemas/Elementos/{{$sistema->stmID}}">Elementos de Sistema</a></li>
            <li class="breadcrumb-item active">Agregar Elemento</li>
          </ol>

          <h2 class="section-title">Agregar Elemento al Sistema: {{$sistema->stmDescripcion}}</h2>
          <p class="section-subtitle">Ingrese los campos para agregar un nuevo elemento.</p><br>

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

          <form method="POST" action="/CrearElemento">
              @csrf
              <input id="stmID" type="hidden" name="stmID" value="{{$sistema->stmID}}" required>

              <div class="form-group row">

                  <label for="descripcion" class="col-md-2 col-form-label text-md-right">Descripción *</label>

                  <div class="col-md-4">
                      <input id="descripcion" type="text" class="form-control{{ Session::has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ old('descripcion') }}" required>

                      @if (Session::has('descripcion'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('descripcion') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="descripcion" class="col-md-2 col-form-label text-md-right">Cantidad *</label>

                  <div class="col-md-4">
                      <input id="cantidad" type="text" class="form-control{{ Session::has('cantidad') ? ' is-invalid' : '' }}" name="cantidad" value="{{ old('cantidad') }}" required>

                      @if (Session::has('cantidad'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('cantidad') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">

                  <label for="codigo" class="col-md-2 col-form-label text-md-right">Código World Office*</label>

                  <div class="col-md-4">
                      <input id="codigo" type="text" class="form-control{{ Session::has('codigo') ? ' is-invalid' : '' }}" name="codigo" value="{{ old('codigo') }}" required>

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
                        Agregrar
                    </button>
                  </div>
              </div>

          </form>


        </div>
    </div>
</div>
@endsection
