@extends('layouts.app')

@section('titulo', 'Cambiar Contraseña')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Cambiar Contraseña</li>
          </ol>

          <h2 class="section-title">Cambiar Contraseña</h2>
          <p class="section-subtitle">Ingrese una nueva contraseña.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarClave">
                @csrf

                <div class="form-group row justify-content-center">
                  <label for="passwordNow" class="col-md-3 col-form-label text-md-right">Contraseña actual *</label>

                  <div class="col-md-4">
                      <input id="passwordNow" type="password" class="form-control{{ Session::has('passwordNow') ? ' is-invalid' : '' }}" name="passwordNow" value="{{ old('passwordNow') }}" required>

                      @if (Session::has('passwordNow'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('passwordNow') }}</strong>
                          </span>
                      @endif
                  </div>

                </div>

                <div class="form-group row justify-content-center">
                    <label for="password" class="col-md-3 col-form-label text-md-right">Contraseña Nueva *</label>

                    <div class="col-md-4">
                        <input id="password" type="password" class="form-control{{ Session::has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>

                        @if (Session::has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('password') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group row justify-content-center">
                  <label for="passwordConfirm" class="col-md-3 col-form-label text-md-right">Confirmar Contraseña Nueva *</label>

                  <div class="col-md-4">
                      <input id="passwordConfirm" type="password" class="form-control{{ Session::has('passwordConfirm') ? ' is-invalid' : '' }}" name="passwordConfirm" value="{{ old('passwordConfirm') }}" required>

                      @if (Session::has('passwordConfirm'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('passwordConfirm') }}</strong>
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


        </div>
    </div>
</div>
@endsection
