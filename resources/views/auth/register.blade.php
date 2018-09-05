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
                  <label for="name" class="col-md-2 col-form-label text-md-right">Nombre(s) *</label>

                  <div class="col-md-4">
                      <input id="name" type="text" class="form-control{{ Session::has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>

                      @if (Session::has('name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('name') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="apellido" class="col-md-2 col-form-label text-md-right">Apellido(s) *</label>

                  <div class="col-md-4">
                      <input id="apellido" type="text" class="form-control{{ Session::has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ old('apellido') }}" required>

                      @if (Session::has('apellido'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('apellido') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">
                  <label for="username" class="col-md-2 col-form-label text-md-right">Nombre de Usuario *</label>

                  <div class="col-md-4">
                      <input id="username" type="text" class="form-control{{ Session::has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                      @if (Session::has('username'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('username') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="rol" class="col-md-2 col-form-label text-md-right">Rol*</label>

                  <div class="col-md-4">
                      <select class="form-control" id="rol" name="rol">
                        @foreach($roles as $r)
                          <option value="{{$r->rusrID}}">{{$r->rusrDescripcion}}</option>
                        @endforeach
                      </select>
                  </div>

              </div>

              <div class="form-group row">
                  <label for="password" class="col-md-2 col-form-label text-md-right">Contraseña *</label>

                  <div class="col-md-4">
                      <input id="password" type="password" class="form-control{{ Session::has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required>

                      @if (Session::has('password'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('password') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="passwordConfirm" class="col-md-2 col-form-label text-md-right">Confirmar Contraseña *</label>

                  <div class="col-md-4">
                      <input id="passwordConfirm" type="password" class="form-control{{ Session::has('passwordConfirm') ? ' is-invalid' : '' }}" name="passwordConfirm" value="{{ old('passwordConfirm') }}" required>

                      @if (Session::has('passwordConfirm'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('passwordConfirm') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">

                  <label for="tipoDocumento" class="col-md-2 col-form-label text-md-right">Tipo de Documento *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="tipoDocumento" name="tipoDocumento">
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="CE">Cédula de Extranjería</option>
                      </select>
                  </div>

                  <label for="cedula" class="col-md-2 col-form-label text-md-right">Número de Documento *</label>

                  <div class="col-md-4">
                      <input id="cedula" type="text" class="form-control{{ Session::has('cedula') ? ' is-invalid' : '' }}" name="cedula" value="{{ old('cedula') }}" required>

                      @if (Session::has('cedula'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('cedula') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group row">
                  <label for="ciudad" class="col-md-2 col-form-label text-md-right">Ciudad *</label>

                  <div class="col-md-4">
                    <select class="form-control" id="ciudad" name="ciudad">
                      <option value="Bogota">Bogotá</option>
                      <option value="Medellin">Medellín</option>
                      <option value="Cali">Cali</option>
                    </select>
                  </div>

                  <label for="celular" class="col-md-2 col-form-label text-md-right">Celular *</label>

                  <div class="col-md-4">
                      <input id="celular" type="text" class="form-control{{ Session::has('celular') ? ' is-invalid' : '' }}" name="celular" value="{{ old('celular') }}" required>

                      @if (Session::has('celular'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('celular') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">


                  <label for="direccion-avenida" class="col-sm-2 col-form-label text-sm-right">Dirección *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="direccion-avenida" name="direccion-avenida" style="width:103px; display:inline; margin-bottom:8px">
                        <option value="Calle">Calle</option>
                        <option value="Carrera">Carrera</option>
                      </select>


                      <label for="direccion-1">:</label>


                      <input id="direccion-1" type="text" class="form-control{{ Session::has('direccion-1') ? ' is-invalid' : '' }}" name="direccion-1" value="{{ old('direccion-1') }}" style="width:70px; display:inline; margin-bottom:8px" required>

                      @if (Session::has('direccion-1'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('direccion-1') }}</strong>
                          </span>
                      @endif

                      <label for="direccion-2">#</label>


                      <input id="direccion-2" type="text" class="form-control{{ Session::has('direccion-2') ? ' is-invalid' : '' }}" name="direccion-2" value="{{ old('direccion-2') }}" style="width:70px; display:inline; margin-bottom:8px" required>

                      @if (Session::has('direccion-2'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('direccion-2') }}</strong>
                          </span>
                      @endif


                      <label for="direccion-3">-</label>


                      <input id="direccion-3" type="text" class="form-control{{ Session::has('direccion-3') ? ' is-invalid' : '' }}" name="direccion-3" value="{{ old('direccion-3') }}" style="width:70px; display:inline; margin-bottom:8px" required>

                      @if (Session::has('direccion-3'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('direccion-3') }}</strong>
                          </span>
                      @endif

                  </div>

                  <label for="direccion-detalle" class="col-md-2 col-form-label text-md-right">Detalle Dirección</label>

                  <div class="col-md-4">
                      <input id="direccion-detalle" type="text" class="form-control{{ Session::has('direccion-detalle') ? ' is-invalid' : '' }}" name="direccion-detalle" value="{{ old('direccion-detalle') }}">

                      @if (Session::has('direccion-detalle'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('direccion-detalle') }}</strong>
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
        <hr>

        </div>
    </div>
</div>
@endsection
