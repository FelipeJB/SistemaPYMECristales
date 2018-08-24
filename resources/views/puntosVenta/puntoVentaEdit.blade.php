@extends('layouts.app')

@section('titulo', 'Editar Punto de Venta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarPuntos">Administrar Puntos de Venta</a></li>
            <li class="breadcrumb-item active">Editar Punto de Venta</li>
          </ol>

          <h2 class="section-title">Editar Punto de Venta: {{$punto->pvNombre}}</h2>
          <p class="section-subtitle">Ingrese los nuevos campos del punto de venta para modificarlos.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarPunto">
                @csrf
                <input id="pvID" type="hidden" name="pvID" value="{{$punto->pvID}}" required>

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Nombre(s) *</label>

                    <div class="col-md-10">
                        <input id="name" type="text" class="form-control{{ Session::has('name') ? ' is-invalid' : '' }}" name="name" value="{{$punto->pvNombre}}" required>

                        @if (Session::has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('name') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group row">

                    <label for="direccion-avenida" class="col-sm-2 col-form-label text-sm-right">Dirección *</label>

                    <div class="col-md-4">
                        <select class="form-control" id="direccion-avenida" name="direccion-avenida" style="width:103px; display:inline; margin-bottom:8px">
                          <option value="Calle" @if($direccion1=="Calle") selected @endif>Calle</option>
                          <option value="Carrera" @if($direccion1=="Carrera") selected @endif>Carrera</option>
                        </select>


                        <label for="direccion-1">:</label>
                        <input id="direccion-1" type="text" class="form-control{{ Session::has('direccion-1') ? ' is-invalid' : '' }}" name="direccion-1" value="{{$direccion2}}" style="width:70px; display:inline; margin-bottom:8px" required>

                        @if (Session::has('direccion-1'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('direccion-1') }}</strong>
                            </span>
                        @endif

                        <label for="direccion-2">#</label>
                        <input id="direccion-2" type="text" class="form-control{{ Session::has('direccion-2') ? ' is-invalid' : '' }}" name="direccion-2" value="{{$direccion3}}" style="width:70px; display:inline; margin-bottom:8px" required>

                        @if (Session::has('direccion-2'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('direccion-2') }}</strong>
                            </span>
                        @endif


                        <label for="direccion-3">-</label>
                        <input id="direccion-3" type="text" class="form-control{{ Session::has('direccion-3') ? ' is-invalid' : '' }}" name="direccion-3" value="{{$direccion4}}" style="width:70px; display:inline; margin-bottom:8px" required>

                        @if (Session::has('direccion-3'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('direccion-3') }}</strong>
                            </span>
                        @endif

                    </div>

                    <label for="direccion-detalle" class="col-md-2 col-form-label text-md-right">Detalle Dirección</label>

                    <div class="col-md-4">
                        <input id="direccion-detalle" type="text" class="form-control{{ Session::has('direccion-detalle') ? ' is-invalid' : '' }}" name="direccion-detalle" value="{{$remaining}}">

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
                          Guardar
                      </button>
                    </div>
                </div>

          </form>


        </div>
    </div>
</div>
@endsection
