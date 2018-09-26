@extends('layouts.app')

@section('titulo', 'Detalle de Venta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/Ventas">Ver Ventas</a></li>
            <li class="breadcrumb-item active">Detalle de Venta</li>
          </ol>

          <h2 class="section-title">Detalle de venta #{{$orden->ordID}}</h2><br>

          <h4>Fecha de la venta: <b>{{$orden->ordFecha}}</b></h4>
          <h4>Precio total: <b>${{number_format($orden->ordTotal)}}</b> con abono de: <b>${{number_format($orden->ordAbono)}}</b> y saldo pendiente de: <b>${{number_format($orden->ordSaldo)}}</b></h4>
          @if($orden->ordObservaciones != null && $orden->ordObservaciones != " ")
          <h4>Observaciones: {{$orden->ordObservaciones}}</h4>
          @endif
          <br>
          <h3>Productos:</h3><br>

          @foreach($detalles as $d)
          <div class="row justify-content-center">
            <div class="col-md-11">

              <h4>Item {{$d->orddItem}}</h4>
              <h6>Sistema <b>{{$d->stmDescripcion}}</b> color <b>{{$d->clrDescripcion}}</b> diseño
                <b>{{$d->dsnCodigo}}</b> milimetraje <b>{{$d->mlmNumero}}mm</b>. {{$d->orddAlto}}mm Alto * {{$d->orddAncho}}mm Ancho,  {{$d->orddCantVidrio}}
                vidrios, {{$d->orddCantToalleros}} toalleros
                @if($d->orddRelacion>0)
                , relación: {{$d->orddRelacion}}
                @endif
                .</h6>
              <h6>Precio: <b>${{number_format($d->orddTotal)}}</b></h6>
              <hr>

            </div>
          </div>
          @endforeach

         <br><a href="/Ventas" class='btn btn-primary' style="float:right;">Atrás</a>
	       <br><br><hr>
        </div>
    </div>
</div>
@endsection
