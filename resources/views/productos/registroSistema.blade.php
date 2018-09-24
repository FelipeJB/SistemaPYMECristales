@extends('layouts.app')

@section('titulo', 'Agregar Sistema')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarSistemas">Administrar Sistemas</a></li>
            <li class="breadcrumb-item active">Agregar Sistema</li>
          </ol>

          <h2 class="section-title">Agregar Sistema</h2>
          <p class="section-subtitle">Ingrese los campos para agregar un nuevo sistema.</p><br>

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

          <form method="POST" action="/CrearSistema">
              @csrf

              <div class="form-group row">

                  <label for="descripcion" class="col-md-2 col-form-label text-md-right">Descripción *</label>

                  <div class="col-md-4">
                      <input id="descripcion" type="text" class="form-control{{ Session::has('descripcion') ? ' is-invalid' : '' }}" name="descripcion" value="{{ old('descripcion') }}" required>

                      @if (Session::has('descripcion'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('descripcion') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="tipo" class="col-md-2 col-form-label text-md-right">Tipo *</label>

                  <div class="col-md-4">
                      <select class="form-control" id="tipo" name="tipo">
                        <option value="Batiente">Batiente</option>
                        <option value="Corrediza">Corrediza</option>
                      </select>
                  </div>

              </div>

              <div class="form-group row">

                  <label for="precioCompra" class="col-md-2 col-form-label text-md-right">Precio de Compra *</label>

                  <div class="col-md-4 input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                      </div>
                      <input id="precioCompra" type="text" class="form-control{{ Session::has('precioCompra') ? ' is-invalid' : '' }}" name="precioCompra" value="{{ old('precioCompra') }}" required>

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
                      <input id="precioVenta" type="text" class="form-control{{ Session::has('precioVenta') ? ' is-invalid' : '' }}" name="precioVenta" value="{{ old('precioVenta') }}" required>

                      @if (Session::has('precioVenta'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('precioVenta') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">

                  <label for="perforaciones" class="col-md-2 col-form-label text-md-right">Perforaciones *</label>

                  <div class="col-md-4">
                      <input id="perforaciones" type="text" class="form-control{{ Session::has('perforaciones') ? ' is-invalid' : '' }}" name="perforaciones" value="{{ old('perforaciones') }}" required>

                      @if (Session::has('perforaciones'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('perforaciones') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="boquetes" class="col-md-2 col-form-label text-md-right">Boquetes *</label>

                  <div class="col-md-4">
                      <input id="boquetes" type="text" class="form-control{{ Session::has('boquetes') ? ' is-invalid' : '' }}" name="boquetes" value="{{ old('boquetes') }}" required>

                      @if (Session::has('boquetes'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('boquetes') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">

                  <label for="bpb" class="col-md-2 col-form-label text-md-right">BPB *</label>

                  <div class="col-md-4">
                      <input id="bpb" type="text" class="form-control{{ Session::has('bpb') ? ' is-invalid' : '' }}" name="bpb" value="{{ old('bpb') }}" required>

                      @if (Session::has('bpb'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('bpb') }}</strong>
                          </span>
                      @endif
                  </div>

                  <label for="chaflan" class="col-md-2 col-form-label text-md-right">Chaflán *</label>

                  <div class="col-md-4">
                      <input id="chaflan" type="text" class="form-control{{ Session::has('chaflan') ? ' is-invalid' : '' }}" name="chaflan" value="{{ old('chaflan') }}" required>

                      @if (Session::has('chaflan'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('chaflan') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row">

                  <label for="codigo" class="col-md-2 col-form-label text-md-right">Código World Office*</label>

                  <div class="col-md-4">
                      <input id="codigo" type="text" class="form-control{{ Session::has('codigo') ? ' is-invalid' : '' }}" name="codigo" value="{{ old('codigo') }}" required>

                      @if (Session::has('codigo'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ Session::get('codigo') }}</strong>
                          </span>
                      @endif
                  </div>

              </div>

              <div class="form-group row mb-0">
                  <div class="col-md-2 offset-md-10">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block">
                        Agregar
                    </button>
                  </div>
              </div>

          </form>
          <hr>

        </div>
    </div>
</div>
@endsection
