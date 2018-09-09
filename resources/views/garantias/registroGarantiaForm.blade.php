@extends('layouts.app')

@section('titulo', 'Registrar Garantia')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Registrar Garantia</li>
          </ol>

          <h2 class="section-title">Registrar Garantía</h2>
          <p class="section-subtitle">Ingrese los datos de la garantía de la orden de venta {{$orden->ordID}}.</p><br>

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

          <form method="POST" action="/RegistrarGarantiaForm">
              @csrf
              <input id="ordID" type="hidden" name="ordID" value="{{$orden->ordID}}" required>

              <div class="form-group row">

                  <label for="observaciones" class="col-md-2 col-form-label text-md-right">Observaciones</label>

                  <div class="col-md-10">
                      <input id="observaciones" type="text" class="form-control{{ Session::has('observaciones') ? ' is-invalid' : '' }}" name="observaciones" value="{{ old('observaciones') }}">

                      @if (Session::has('observaciones'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('observaciones') }}</strong>
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
