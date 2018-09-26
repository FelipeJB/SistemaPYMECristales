@extends('layouts.app')

@section('titulo', 'Generar Planos de Medidas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Generar Planos de Medidas</li>
          </ol>

          <h2 class="section-title">Generar Planos de Medidas</h2>
          <p class="section-subtitle">Ingrese el número de orden para generar los planos de las medidas.</p><br>

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

          <form method="POST" action="/GenerarPlanosMedidas">
              @csrf

              <div class="form-group row">

                  <label for="numero" class="col-md-4 col-form-label text-md-right">Número de Orden *</label>

                  <div class="col-md-4">
                      <input id="numero" type="text" class="form-control{{ Session::has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{ old('numero') }}" required>

                      @if (Session::has('numero'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('numero') }}</strong>
                          </span>
                      @endif
                  </div>

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
        </div>
    </div>
</div>
@endsection
