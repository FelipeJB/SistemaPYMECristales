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

          <h2 class="section-title">Registrar Venta a {{$cliente->cltNombre}} {{$cliente->cltApellido}}</h2>
          <p class="section-subtitle">Ingrese los datos de la orden de venta para finalizar el proceso.</p><br>

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

          <form method="POST" action="/CrearOrden">
              @csrf

              <div class="form-group row">

                <label for="punto" class="col-md-2 col-form-label text-md-right">Punto de Venta *</label>

                <div class="col-md-4">
                    <select class="form-control" id="punto" name="punto">
                      @foreach($puntos as $p)
                        <option value="{{$p->pvID}}">{{$p->pvNombre}}</option>
                      @endforeach
                    </select>
                </div>

                  <label for="formaPago" class="col-md-2 col-form-label text-md-right">Forma de pago *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="formaPago" name="formaPago">
                        @foreach($formasPago as $f)
                          <option value="{{$f->fpID}}">{{$f->fpDescripcion}}</option>
                        @endforeach
                      </select>
                  </div>

              </div>

              <div class="form-group row">

                <label for="total" class="col-md-2 col-form-label text-md-right">Precio a pagar</label>

                <div class="col-md-4 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                    <input id="total" type="text" class="form-control{{ Session::has('total') ? ' is-invalid' : '' }}" name="total" value="{{ number_format($valorTotal) }}" disabled>
                    @if (Session::has('total'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ Session::get('total') }}</strong>
                        </span>
                    @endif
                </div>

                <label for="abono" class="col-md-2 col-form-label text-md-right">Abono *</label>

                <div class="col-md-4 input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                    <input id="abono" type="text" class="form-control{{ Session::has('abono') ? ' is-invalid' : '' }}" name="abono" value="{{ old('abono') }}" required>
                    @if (Session::has('abono'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ Session::get('abono') }}</strong>
                        </span>
                    @endif
                </div>

              </div>

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
                        Finalizar
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
                  <p class="badge badge-success" style="font-size:13px; margin:5px 5px">Registrar Detalles</p>
                  <p class="badge badge-success" style="font-size:13px; margin:5px 5px">Confirmación</p>
                  <p class="badge badge-secondary" style="font-size:13px; margin:5px 5px">Registrar Orden</p>
              </center>
              </div>
            </div>
          </div>


        </div>
    </div>
</div>
@endsection
