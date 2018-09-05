@extends('layouts.app')

@section('titulo', 'Editar Milimetraje')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarMilimetrajes">Administrar Milimetrajes</a></li>
            <li class="breadcrumb-item active">Editar Milimetraje</li>
          </ol>

          <h2 class="section-title">Editar Milimetraje: {{$milimetraje->mlmNumero}} mm</h2>
          <p class="section-subtitle">Ingrese el nuevo valor del milimetraje.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarMilimetraje">
                @csrf
                <input id="mlmID" type="hidden" name="mlmID" value="{{$milimetraje->mlmID}}" required>

                <div class="form-group row">
                    <label for="numero" class="col-md-4 col-form-label text-md-right">Número *</label>

                    <div class="col-md-4">
                        <input id="numero" type="text" class="form-control{{ Session::has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{$milimetraje->mlmNumero}}" required>

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
