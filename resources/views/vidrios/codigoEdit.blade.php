@extends('layouts.app')

@section('titulo', 'Editar Código')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarCodigos">Administrar Códigos</a></li>
            <li class="breadcrumb-item active">Editar Código</li>
          </ol>

          <h2 class="section-title">Editar Código de World Office</h2>
          <p class="section-subtitle">Ingrese el nuevo código para modificarlo.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarCodigo">
                @csrf
                <input id="cdgID" type="hidden" name="cdgID" value="{{$codigo->cdgID}}" required>

                <div class="form-group row">

                    <label for="color" class="col-md-2 col-form-label text-md-right">Color </label>

                    <div class="col-md-4">
                        <input id="color" type="text" class="form-control{{ Session::has('color') ? ' is-invalid' : '' }}" name="color" value="{{$codigo->clrDescripcion}}" disabled>

                        @if (Session::has('color'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('color') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="milimetraje" class="col-md-2 col-form-label text-md-right">Milimetraje </label>

                    <div class="col-md-4">
                        <input id="milimetraje" type="text" class="form-control{{ Session::has('milimetraje') ? ' is-invalid' : '' }}" name="milimetraje" value="{{$codigo->mlmNumero}}" disabled>

                        @if (Session::has('milimetraje'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('milimetraje') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group row">

                    <label for="codigo" class="col-md-2 col-form-label text-md-right">Código World Office*</label>

                    <div class="col-md-4">
                        <input id="codigo" type="text" class="form-control{{ Session::has('codigo') ? ' is-invalid' : '' }}" name="codigo" value="{{$codigo->cdgWO}}" required>

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


        </div>
    </div>
</div>
@endsection
