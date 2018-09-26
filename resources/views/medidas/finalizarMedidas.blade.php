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

          <center><h2 style="margin-top:30px">Medidas registradas exitosamente para la orden: {{$id}}</h2></center>

          <div class="row mb-0">
              <div class="col-lg-2 offset-lg-4">
                <br>
                <a href="/GenerarPlanosMedidas/{{$id}}" class='btn btn-primary btn-block'>Generar Planos</a>
              </div>
              <div class="col-lg-2">
                <br>
                <a href="/" class='btn btn-primary btn-block'>Volver al Inicio</a>
              </div>
          </div>


          <hr style="margin-top:30px">
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
                  <p class="badge badge-success" style="font-size:13px; margin:5px 5px">Registrar Orden</p>
              </center>
              </div>
            </div>
          </div>


        </div>
    </div>
</div>
@endsection
