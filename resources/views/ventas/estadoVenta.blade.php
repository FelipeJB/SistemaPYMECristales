@extends('layouts.app')

@section('titulo', 'Consultar Venta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Consultar Venta</li>
          </ol>

          <h2 class="section-title">Consultar Estado de Orden de Venta #{{$id}}</h2>

          <div class="row mb-0">
              <div class="col-lg-6 offset-lg-3">
                <center><h3 style="margin-top:30px">{{$estado->stdDescripcion}}</h3></center>
                <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="{{$estado->stdID/6}}" aria-valuemin="0" aria-valuemax="1" style="width: {{($estado->stdID/4)*100}}%"></div>
                </div>
              </div>
          </div>

          <div class="row mb-0">
              <div class="col-lg-2 offset-lg-10">
                <br>
                <a href="/" class='btn btn-primary btn-block' style="margin-top:20px">Volver al Inicio</a>
              </div>
          </div>

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



          <hr>
        </div>
    </div>
</div>
@endsection
