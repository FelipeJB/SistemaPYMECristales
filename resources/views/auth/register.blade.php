@extends('layouts.app')

@section('titulo', 'Registrar Usuario')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Registrar Usuario</li>
          </ol>

          <h2 class="section-title">Registrar usuario</h2>
          <p class="section-subtitle">Ingrese los campos para registrar un nuevo usuario.</p><br>

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

          <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
              @csrf

              <div class="form-group row">
                  <label for="name" class="col-md-2 col-form-label text-md-right">Nombre</label>

                  <div class="col-md-4">
                      <input id="name" type="text" class="form-control{{ Session::has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                      @if (Session::has('name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('name') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="cedula" class="col-md-2 col-form-label text-md-right">Cédula</label>

                  <div class="col-md-4">
                      <input id="cedula" type="text" class="form-control{{ Session::has('cedula') ? ' is-invalid' : '' }}" name="cedula" value="{{ old('cedula') }}" required autofocus>

                      @if (Session::has('cedula'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('cedula') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">
                  <label for="username" class="col-md-2 col-form-label text-md-right">Nombre de Usuario</label>

                  <div class="col-md-4">
                      <input id="username" type="text" class="form-control{{ Session::has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                      @if (Session::has('username'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('username') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="rol" class="col-md-2 col-form-label text-md-right">Rol</label>

                  <div class="col-md-4">
                      <select class="form-control" id="rol" name="rol">
                        <option value="1">Administrador</option>
                        <option value="2">Administrador</option>
                        <option value="3">Administrador</option>
                        <option value="4">Administrador</option>
                      </select>
                  </div>

              </div>

              <div class="form-group row">
                  <label for="password" class="col-md-2 col-form-label text-md-right">Contraseña</label>

                  <div class="col-md-4">
                      <input id="password" type="password" class="form-control{{ Session::has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus>

                      @if (Session::has('password'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('password') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="passwordConfirm" class="col-md-2 col-form-label text-md-right">Confirmar Contraseña</label>

                  <div class="col-md-4">
                      <input id="passwordConfirm" type="password" class="form-control{{ Session::has('passwordConfirm') ? ' is-invalid' : '' }}" name="passwordConfirm" value="{{ old('passwordConfirm') }}" required autofocus>

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
                        Registrar
                    </button>
                  </div>
              </div>

        </form>

        </div>
    </div>
</div>
@endsection
