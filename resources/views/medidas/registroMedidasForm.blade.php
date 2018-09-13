@extends('layouts.app')

@section('titulo', 'Tomar Medidas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Tomar Medidas</li>
          </ol>

          <h2 class="section-title">Tomar Medidas</h2>
          <h4>Orden: {{$orden->ordNumeroPedido}}, Item {{$detalle->orddItem}} (Sistema {{$detalle->stmDescripcion}}, Color {{$detalle->clrDescripcion}},
              Diseno {{$detalle->dsnCodigo}}, {{$detalle->mlmNumero}}mm)</h4>
          <p class="section-subtitle">Ingrese los campos solicitados para registrar las medidas del ítem respectivo.</p><br>

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

          <div class="row">
            <div class="col-md-6">
              <h5 style="text-align:center">¿Se pudo tomar las medidas?</h5>
            </div>
            <div class="col-md-6">
              <center>
              <button type="button" class="btn btn-success" onclick="tomarMedidas()" style="width: 90px; margin-bottom:20px; margin-right: 5px;">Si</button>
              <button type="button" class="btn btn-danger" onclick="noTomarMedidas()" style="width: 90px; margin-bottom:20px">No</button>
            </center>
            </div>
          </div>

          <form method="POST" action="/RegistrarMedidasForm">
              @csrf
              <input id="ordID" type="hidden" name="ordID" value="{{$orden->ordID}}" required>

              <fieldset class="formMedidasPositivas" style="margin-top: 20px; display:none">
                <div class="form-group row">


                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-2 offset-md-10">
                      <br>
                      <button type="submit" name="action" value="registrarMedidas"  class="btn btn-primary btn-block">
                          Continuar
                      </button>
                    </div>
                </div>
              </fieldset>


              <fieldset  class="formMedidasNegativas" style="margin-top: 20px; display:none">
                <div class="form-group row">

                  <label for="motivo" class="col-md-2 col-form-label text-md-right">Motivo</label>

                  <div class="col-md-10">
                      <input id="motivo" type="text" class="form-control{{ Session::has('motivo') ? ' is-invalid' : '' }}" name="motivo" value="{{ old('motivo') }}" required>

                      @if (Session::has('motivo'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('motivo') }}</strong>
                          </span>
                      @endif
                  </div>

                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-2 offset-md-10">
                      <br>
                      <button type="submit" name="action" value="noNegistrarMedidas" class="btn btn-primary btn-block">
                          Continuar
                      </button>
                    </div>
                </div>
              </fieldset>

          </form>

          <hr>



        </div>
    </div>
</div>
@endsection
