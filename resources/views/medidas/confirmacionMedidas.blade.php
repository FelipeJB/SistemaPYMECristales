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

          <h2 class="section-title">Confirmar Medidas</h2>
          <h4>Orden: {{$numOrden}}</h4>
          <p class="section-subtitle">A continuación se muestra el resumen de las medidas ingresadas.</p><br>

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

          @for($i = 0; $i < count($medidas); $i++)

            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-sm-10">
                    <h4 class="card-title">Item {{$detalles[$i]->orddItem}} (Sistema {{$detalles[$i]->stmDescripcion}}, Color {{$detalles[$i]->clrDescripcion}},
                        Diseno {{$detalles[$i]->dsnCodigo}}, {{$detalles[$i]->mlmNumero}}mm)</h4>

                        @if($medidas[$i]->esPositiva)
                          <h6 style="line-height:25px">
                            Puerta a la <b>{{$medidas[$i]->ladoPuerta}}</b>, <b>{{$medidas[$i]->alto}}mm</b> de alto,
                            @if($medidas[$i]->esCompuesto)
                              <b>{{$medidas[$i]->ancho1}}mm</b> de ancho
                            @else
                              <b>{{$medidas[$i]->ancho1}}mm</b> de ancho abajo, <b>{{$medidas[$i]->ancho2}}mm</b> de ancho arriba
                            @endif
                            @if ($medidas[$i]->esBatiente)
                              , <b>{{$medidas[$i]->ancho2}}mm</b> de ancho de la puerta
                            @endif .
                            @if ($medidas[$i]->observaciones !=null)
                            <br> Observaciones: {{$medidas[$i]->observaciones}}.
                            @endif
                          </h6>
                        @else
                          <h5 style="line-height:25px">
                          Las medidas no pudieron tomarse<br>
                          Motivo: {{$medidas[$i]->razonNegativa}}
                          </h5>
                        @endif

                  </div>
                  <div class="col-md-2">
                    <a href="/EditarMedida/{{$i}}" class='btn btn-primary btn-block'>Editar</a>
                  </div>
                </div>
              </div>
            </div>

          @endfor

          <div class="row mb-0">
              <div class="col-lg-2 offset-lg-8">
                <br>
                <a href="/CancelarMedidas" class='btn btn-danger btn-block'>Cancelar</a>
              </div>
              <div class="col-lg-2">
                <br>
                <a href="/CrearMedidas" class='btn btn-success btn-block'>Confirmar</a>
              </div>
          </div>

          <hr>

        </div>
    </div>
  </div>
  @endsection
