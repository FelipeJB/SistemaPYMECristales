@extends('layouts.app')

@section('titulo', 'Emitir Informes')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Emitir Informes</li>
          </ol>

          <h2 class="section-title">Emitir Informes</h2>
          <p class="section-subtitle">Seleccione el tipo de informe que desea emitir junto con su respectivo mes y año.</p><br>

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

          <form method="POST" action="/EmitirInformes">
              @csrf

              <div class="form-group row">


                  <div class="col-md-6">
                    <center>
                      <b><label>Tipo de informe</label></b><br>

                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-primary" style="width:120px">
                        <input type="radio" name="tipo" id="ventas" value="ventas" autocomplete="off"> Ventas
                      </label>
                      <label class="btn btn-primary active" style="width:120px">
                        <input type="radio" name="tipo" id="garantias" value="garantias" autocomplete="off"  checked=""> Garantías
                      </label>
                      <label class="btn btn-primary" style="width:120px">
                        <input type="radio" name="tipo" id="instalaciones" value="instalaciones" autocomplete="off"> Instalaciones
                      </label>
                      </div>
                    </center>
                  </div>

                  <div class="col-md-6">

                    <div class="form-group row">

                        <label for="mes" class="col-md-3 col-form-label text-md-right">Mes *</label>

                        <div class="col-md-7">
                          <select class="form-control" id="mes" name="mes">
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                          </select>
                        </div>

                    </div>

                    <div class="form-group row">

                        <label for="anio" class="col-md-3 col-form-label text-md-right">Año *</label>

                        <div class="col-md-7">
                            <input id="anio" type="text" class="form-control{{ Session::has('anio') ? ' is-invalid' : '' }}" name="anio" value="{{ old('anio') }}" required>

                            @if (Session::has('anio'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ Session::get('anio') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>

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
