@extends('layouts.app')

@section('titulo', 'Migrar Datos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Migrar Datos</li>
          </ol>

          <h2 class="section-title">Migrar datos</h2>
          <p class="section-subtitle">Seleccione el tipo de migración que desee realizar para generar los documentos de integración a World Office.</p><br>

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

          <form method="POST" action="/MigrarDatos">
              @csrf

              <div class="form-group row">

                        <label for="tipo" class="col-md-3 col-form-label text-md-right">Tipo *</label>

                        <div class="col-md-6">
                          <select class="form-control" id="tipo" name="tipo">
                            <option value="0">Migrar todos los datos no migrados</option>
                            @foreach($migraciones as $m)
                              <option value="{{$m->mgcID}}">Migración {{$m->mgcID}} realizada en {{$m->mgcFecha}}</option>
                            @endforeach
                          </select>
                        </div>

              </div>

              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-10">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block">
                        Emitir
                    </button>
                  </div>
              </div>

          </form>





	         <hr>
        </div>
    </div>
</div>
@endsection
