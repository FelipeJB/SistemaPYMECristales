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

          <h2 class="section-title">Confirmar Detalles de venta</h2>
          <h4>Cliente: {{$cliente->cltNombre}} {{$cliente->cltApellido}}</h4>
          <p class="section-subtitle">A continuación se muestra el resumen de los detalles de la venta.</p><br>

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

          @foreach($detalles as $d)

            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-sm-10">
                    <h4 class="card-title">Detalle {{$d->orddItem}}</h4>
                    <h6>Sistema {{$sistemas[$d->orddItem-1]->stmDescripcion}} color {{$colores[$d->orddItem-1]->clrDescripcion}} diseño
                      {{$disenos[$d->orddItem-1]->dsnCodigo}} {{$milimetrajes[$d->orddItem-1]->mlmNumero}}mm, {{$d->orddAlto}}mm Alto * {{$d->orddAncho}}mm Ancho,  {{$d->orddCantVidrio}}
                      vidrios, {{$d->orddCantToalleros}} toalleros
                      @if($d->orddRelacion>0)
                      , relación: {{$d->orddRelacion}}
                      @endif
                      .</h6>
                    <h6>Precio: <b>${{number_format($d->orddTotal)}}</b></h6>
                  </div>
                  <div class="col-md-2">
                    <a href="/EliminarDetalle/{{$d->orddItem}}" class='btn btn-danger btn-block'>Eliminar</a>
                  </div>
                </div>
              </div>
            </div>

          @endforeach
          <div class="row justify-content-center">
            <h5 style="margin-top:10px">Precio total: <b>${{number_format($total)}}</b></h5>
          </div>

          <div class="row mb-0">
              <div class="col-lg-2 offset-lg-6">
                <br>
                <a href="/CancelarOrden" class='btn btn-danger btn-block'>Cancelar</a>
              </div>
              <div class="col-lg-2">
                <br>
                <a href="/CrearDetalle" class='btn btn-primary btn-block'>Nuevo Detalle</a>
              </div>
              <div class="col-lg-2">
                <br>
                <a href="/CrearOrden" class='btn btn-success btn-block'>Confirmar</a>
              </div>
          </div>

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
                  <p class="badge badge-secondary" style="font-size:13px; margin:5px 5px">Confirmación</p>
                  <p class="badge" style="font-size:13px; margin:5px 5px">Registrar Orden</p>
              </center>
              </div>
            </div>
          </div>


        </div>
    </div>
</div>
@endsection
