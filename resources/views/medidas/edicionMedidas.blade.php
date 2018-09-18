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

          <h2 class="section-title">Editar Medidas</h2>
          <h4>Item {{$detalle->orddItem}} (Sistema {{$detalle->stmDescripcion}}, Color {{$detalle->clrDescripcion}},
              Diseno {{$detalle->dsnCodigo}}, {{$detalle->mlmNumero}}mm)</h4>
          <p class="section-subtitle">Ingrese las nuevas medidas.</p><br>

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

          <form method="POST" action="/EditarMedida">
              @csrf
              <input id="item" type="hidden" name="item" value="{{$item}}" required>
              <input id="orddID" type="hidden" name="orddID" value="{{$detalle->orddID}}" required>

              <fieldset class="formMedidasPositivas" style="margin-top: 20px; display:none">
                <div class="form-group row">
                  <label for="lado" class="col-md-2 col-form-label text-md-right">Lado de la puerta</label>

                  <div class="col-md-4">
                    <select class="form-control" id="lado" name="lado">
                      <option value="Derecha"  @if($medida->ladoPuerta=="Derecha") selected @endif >Derecha</option>
                      <option value="Izquierda" @if($medida->ladoPuerta=="Izquierda") selected @endif >Izquierda</option>
                    </select>
                  </div>

                  <label for="alto" class="col-md-2 col-form-label text-md-right">Alto *</label>

                  <div class="col-md-4 input-group">
                      <input id="alto" type="text" class="form-control{{ Session::has('alto') ? ' is-invalid' : '' }}" name="alto" value="{{$medida->alto}}">
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('alto'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('alto') }}</strong>
                          </span>
                      @endif
                  </div>


                </div>
                @if($detalle->orddRelacion != 0)
                <div class="form-group row">
                  <label for="ancho1" class="col-md-2 col-form-label text-md-right">Ancho 1 Izquierda *</label>

                  <div class="col-md-4 input-group">
                      <input id="ancho1" type="text" class="form-control{{ Session::has('ancho1') ? ' is-invalid' : '' }}" name="ancho1" value="{{$medida->ancho1}}">
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('ancho1'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('ancho1') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="ancho2" class="col-md-2 col-form-label text-md-right">Ancho 2 Derecha *</label>

                  <div class="col-md-4 input-group">
                      <input id="ancho2" type="text" class="form-control{{ Session::has('ancho2') ? ' is-invalid' : '' }}" name="ancho2" value="{{$medida->ancho2}}">
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('ancho2'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('ancho2') }}</strong>
                          </span>
                      @endif
                  </div>

                </div>
                @else
                <div class="form-group row">
                  <label for="ancho1" class="col-md-2 col-form-label text-md-right">Ancho abajo *</label>

                  <div class="col-md-4 input-group">
                      <input id="ancho1" type="text" class="form-control{{ Session::has('ancho1') ? ' is-invalid' : '' }}" name="ancho1" value="{{$medida->ancho1}}">
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('ancho1'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('ancho1') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="ancho2" class="col-md-2 col-form-label text-md-right">Ancho arriba *</label>

                  <div class="col-md-4 input-group">
                      <input id="ancho2" type="text" class="form-control{{ Session::has('ancho2') ? ' is-invalid' : '' }}" name="ancho2" value="{{$medida->ancho2}}">
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('ancho2'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('ancho2') }}</strong>
                          </span>
                      @endif
                  </div>

                </div>
                @endif



                <div class="form-group row">

                  @if($detalle->stmTipo == 'Batiente')
                  <label for="anchoPuerta" class="col-md-2 col-form-label text-md-right">Ancho de la puerta *</label>

                  <div class="col-md-4 input-group">
                      <input id="anchoPuerta" type="text" class="form-control{{ Session::has('anchoPuerta') ? ' is-invalid' : '' }}" name="anchoPuerta" value="{{$medida->anchoPuerta}}">
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('anchoPuerta'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('anchoPuerta') }}</strong>
                          </span>
                      @endif
                  </div>
                  @endif

                  <label for="observaciones" class="col-md-2 col-form-label text-md-right">Observaciones</label>

                  <div class="col-md-4">
                      <input id="observaciones" type="text" class="form-control{{ Session::has('observaciones') ? ' is-invalid' : '' }}" name="observaciones" value="{{$medida->observaciones}}">

                      @if (Session::has('observaciones'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('observaciones') }}</strong>
                          </span>
                      @endif
                  </div>

                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-2 offset-md-8">
                      <br>
                      <button type="submit" name="action" value="cancelar" class="btn btn-danger btn-block">
                          Cancelar
                      </button>
                    </div>
                    <div class="col-md-2">
                      <br>
                      <button type="submit" name="action" value="registrarMedidas"  class="btn btn-primary btn-block">
                          Guardar
                      </button>
                    </div>
                </div>
              </fieldset>


              <fieldset  class="formMedidasNegativas" style="margin-top: 20px; display:none">
                <div class="form-group row">

                  <label for="motivo" class="col-md-2 col-form-label text-md-right">Motivo *</label>

                  <div class="col-md-10">
                      <input id="motivo" type="text" class="form-control{{ Session::has('motivo') ? ' is-invalid' : '' }}" name="motivo" value="{{$medida->razonNegativa}}">

                      @if (Session::has('motivo'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('motivo') }}</strong>
                          </span>
                      @endif
                  </div>

                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-2 offset-md-8">
                      <br>
                      <button type="submit" name="action" value="cancelar" class="btn btn-danger btn-block">
                          Cancelar
                      </button>
                    </div>
                    <div class="col-md-2">
                      <br>
                      <button type="submit" name="action" value="noRegistrarMedidas" class="btn btn-primary btn-block">
                          Guardar
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
