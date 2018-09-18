@extends('layouts.app')

@section('titulo', 'Editar Precio')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarPrecios">Administrar Precios</a></li>
            <li class="breadcrumb-item active">Editar Precio</li>
          </ol>

          <h2 class="section-title">Editar Precio</h2>
          <p class="section-subtitle">Ingrese los nuevos precios para el vidrio seleccionado.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarPrecio">
                @csrf
                <input id="pvdID" type="hidden" name="pvdID" value="{{$precio->pvdID}}" required>

                <div class="form-group row">

                    <label for="sistema" class="col-md-2 col-form-label text-md-right">Sistema </label>

                    <div class="col-md-4">
                        <input id="sistema" type="text" class="form-control{{ Session::has('sistema') ? ' is-invalid' : '' }}" name="sistema" value="{{$precio->stmDescripcion}}" disabled>

                        @if (Session::has('sistema'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('sistema') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="milimetraje" class="col-md-2 col-form-label text-md-right">Milimetraje </label>

                    <div class="col-md-4">
                        <input id="milimetraje" type="text" class="form-control{{ Session::has('milimetraje') ? ' is-invalid' : '' }}" name="milimetraje" value="{{$precio->mlmNumero}}" disabled>

                        @if (Session::has('milimetraje'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('milimetraje') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group row">
                    <label for="precioCompra" class="col-md-2 col-form-label text-md-right">Precio de Compra *</label>

                    <div class="col-md-4 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">$</span>
                        </div>
                        <input id="precioCompra" type="text" class="form-control{{ Session::has('precioCompra') ? ' is-invalid' : '' }}" name="precioCompra" value="{{$precio->pvdPrecioCompra}}" required>
                        <div class="input-group-append">
                          <span class="input-group-text">/m<sup>2</sup></span>
                        </div>

                        @if (Session::has('precioCompra'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('precioCompra') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="precioVenta" class="col-md-2 col-form-label text-md-right">Precio de Venta *</label>

                    <div class="col-md-4 input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">$</span>
                        </div>
                        <input id="precioVenta" type="text" class="form-control{{ Session::has('precioVenta') ? ' is-invalid' : '' }}" name="precioVenta" value="{{$precio->pvdPrecioVenta}}" required>
                        <div class="input-group-append">
                          <span class="input-group-text">/m<sup>2</sup></span>
                        </div>
                        
                        @if (Session::has('precioVenta'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('precioVenta') }}</strong>
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
