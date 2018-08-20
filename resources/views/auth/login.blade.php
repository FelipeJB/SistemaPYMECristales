@extends('layouts.app')

@section('titulo', 'Ingresar')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary mb-3">
                <div class="card-header">Ingreso a {{ config('app.name', 'Laravel') }}</div>

                <div class="card-body">
                  <div class="row justify-content-center">

                      <img src="{{ URL::asset('img/Logo-full.png') }}" class="img-fluid" style="max-height:160px; margin-bottom:20px;"><br><br>

                  </div>
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                        @csrf

                        @if(session()->has('login_error'))
                          <div class="alert alert-danger">
                            {{ session()->get('login_error') }}
                          </div>
                        @endif
                        <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }} row">
                          <label for="identity" class="col-md-4 col-form-label text-md-right">Nombre de usuario</label>

                          <div class="col-md-6">
                            <input id="identity" type="identity" class="form-control" name="identity" value="{{ old('identity') }}" autofocus required>

                            @if ($errors->has('identity'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('identity') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <button type="submit" class="btn btn-primary">
                                Iniciar Sesión
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
