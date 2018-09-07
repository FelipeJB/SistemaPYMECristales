@extends('layouts.app')

@section('titulo', 'Registrar Venta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Registrar Venta</li>
          </ol>

          <h2 class="section-title">Registrar Detalle de Venta {{count($detalles)+1}}</h2>
          <h4>Cliente: {{$cliente->cltNombre}} {{$cliente->cltApellido}}</h4>
          <p class="section-subtitle">Ingrese los datos del detalle número {{count($detalles)+1}} de la orden de venta.</p><br>

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

          <form method="POST" action="/CrearDetalle">
              @csrf

              <div class="form-group row">

                <label for="sistema" class="col-md-2 col-form-label text-md-right">Sistema *</label>

                <div class="col-md-4">
                    <select class="form-control" id="sistema" name="sistema">
                      @foreach($sistemas as $s)
                        <option value="{{$s->stmID}}">{{$s->stmDescripcion}}</option>
                      @endforeach
                    </select>
                </div>

                  <label for="milimetraje" class="col-md-2 col-form-label text-md-right">Milimetraje *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="milimetraje" name="milimetraje">
                        @foreach($milimetrajes as $m)
                          <option value="{{$m->mlmID}}">{{$m->mlmNumero}}</option>
                        @endforeach
                      </select>
                  </div>

              </div>

              <div class="form-group row">

                <label for="color" class="col-md-2 col-form-label text-md-right">Color *</label>

                <div class="col-md-4">
                    <select class="form-control" id="color" name="color">
                      @foreach($colores as $c)
                        <option value="{{$c->clrID}}">{{$c->clrDescripcion}}</option>
                      @endforeach
                    </select>
                </div>

                  <label for="diseno" class="col-md-2 col-form-label text-md-right">Diseño *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="diseno" name="diseno">
                        @foreach($disenos as $d)
                          <option value="{{$d->dsnID}}">{{$d->dsnDescripcion}}</option>
                        @endforeach
                      </select>
                  </div>

              </div>

              <div class="form-group row">
                  <label for="vidrios" class="col-md-2 col-form-label text-md-right">Cantidad de Vidrios *</label>

                  <div class="col-md-4">
                      <input id="vidrios" type="text" class="form-control{{ Session::has('vidrios') ? ' is-invalid' : '' }}" name="vidrios" value="{{ old('vidrios') }}" required>

                      @if (Session::has('vidrios'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('vidrios') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="toalleros" class="col-md-2 col-form-label text-md-right">Cantidad de Toalleros *</label>

                  <div class="col-md-4">
                      <input id="toalleros" type="text" class="form-control{{ Session::has('toalleros') ? ' is-invalid' : '' }}" name="toalleros" value="{{ old('toalleros') }}" required>

                      @if (Session::has('toalleros'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('toalleros') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">
                <label for="adicional" class="col-md-2 col-form-label text-md-right">Valor Adicional</label>

                <div class="col-md-4 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                    <input id="adicional" type="text" class="form-control{{ Session::has('adicional') ? ' is-invalid' : '' }}" name="adicional" value="{{ old('adicional') }}">
                    @if (Session::has('adicional'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ Session::get('adicional') }}</strong>
                        </span>
                    @endif
                </div>

                  <label for="motivo" class="col-md-2 col-form-label text-md-right">Motivo Valor Adicional</label>

                  <div class="col-md-4">
                      <input id="motivo" type="text" class="form-control{{ Session::has('motivo') ? ' is-invalid' : '' }}" name="motivo" value="{{ old('motivo') }}">

                      @if (Session::has('motivo'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('motivo') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">

                  <label for="observaciones" class="col-md-2 col-form-label text-md-right">Observaciones</label>

                  <div class="col-md-4">
                      <input id="observaciones" type="text" class="form-control{{ Session::has('observaciones') ? ' is-invalid' : '' }}" name="observaciones" value="{{ old('observaciones') }}">

                      @if (Session::has('observaciones'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('observaciones') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="relacion" class="col-md-2 col-form-label text-md-right">Relación *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="relacion" name="relacion">
                        <option value="0">Ninguna</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                  </div>

              </div>

              <div class="form-group row">
                  <label for="alto" class="col-md-2 col-form-label text-md-right">Alto *</label>

                  <div class="col-md-2 input-group">
                      <input id="alto" type="text" class="form-control{{ Session::has('alto') ? ' is-invalid' : '' }}" name="alto" value="{{ old('alto') }}" required>
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('alto'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('alto') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="ancho" class="col-md-2 col-form-label text-md-right">Ancho *</label>

                  <div class="col-md-2 input-group">
                      <input id="ancho" type="text" class="form-control{{ Session::has('ancho') ? ' is-invalid' : '' }}" name="ancho" value="{{ old('ancho') }}" required>
                      <div class="input-group-append">
                        <span class="input-group-text">mm</span>
                      </div>

                      @if (Session::has('ancho'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('ancho') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="descuento" class="col-md-2 col-form-label text-md-right">Descuento </label>

                  <div class="col-md-2 input-group">

                      <input id="descuento" type="text" class="form-control{{ Session::has('descuento') ? ' is-invalid' : '' }}" name="descuento" value="{{ old('descuento') }}">
                      <div class="input-group-append">
                        <span class="input-group-text">%</span>
                      </div>
                      @if (Session::has('descuento'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('descuento') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-8">
                    <br>
                    <button type="submit" name="action" value="continue" class="btn btn-primary btn-block">
                        Nuevo Detalle
                    </button>
                  </div>
                  <div class="col-md-2">
                    <br>
                    <button type="submit" name="action" value="finish" class="btn btn-success btn-block">
                        Continuar a Orden
                    </button>
                  </div>
              </div>

          </form>

          <hr>
          <div class="row justify-content-center" style="margin-top:25px;">
            <div class="col-md-6">
              <center>
                <h3>Progreso</h3>
              </center>
              <div class="alert alert-light">
                <center>
                  <p class="badge badge-success" style="font-size:13px; margin:5px 8px">Seleccionar Cliente</p>
                  <p class="badge badge-secondary" style="font-size:13px; margin:5px 5px">Registrar Detalles</p>
                  <p class="badge" style="font-size:13px; margin:5px 5px">Confirmación</p>
                  <p class="badge" style="font-size:13px; margin:5px 5px">Registrar Orden</p>
              </center>
              </div>
            </div>
          </div>


        </div>
    </div>
</div>
@endsection
