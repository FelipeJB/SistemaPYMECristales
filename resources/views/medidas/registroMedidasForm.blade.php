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

          <h2 class="section-title">Tomar Medidas</h2>
          <p class="section-subtitle">Subtítulo</p><br>

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

          <form method="POST" action="/RegistrarMedidasForm">
              @csrf
              <input id="ordID" type="hidden" name="ordID" value="{{$orden->ordID}}" required>

              <div class="form-group row">


              </div>


              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-10">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block">
                        Registrar
                    </button>
                  </div>
              </div>

          </form>

          <hr>



        </div>
    </div>
</div>
@endsection
