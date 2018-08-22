@extends('layouts.app')

@section('titulo', 'Editar Usuario')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarUsuarios">Administrar Usuarios</a></li>
            <li class="breadcrumb-item active">Editar Usuario</li>
          </ol>

          <h2 class="section-title">Editar Usuario: {{$usuario->usrNombre." ".$usuario->usrApellido}}</h2>
          <p class="section-subtitle">Ingrese los nuevos campos del usuario para modificarlos.</p><br>

          @if(Session::has('error'))
              <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><i class="fa fa-check"></i></strong> {!! Session::get('error') !!}
              </div>
          @endif

            <form method="POST" action="/EditarUsuario">
                @csrf
                <input id="username" type="hidden" name="username" value="{{$usuario->usrUsuario}}" required>

                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">Nombre(s) *</label>

                    <div class="col-md-4">
                        <input id="name" type="text" class="form-control{{ Session::has('name') ? ' is-invalid' : '' }}" name="name" value="{{$usuario->usrNombre}}" required>

                        @if (Session::has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <label for="apellido" class="col-md-2 col-form-label text-md-right">Apellido(s) *</label>

                    <div class="col-md-4">
                        <input id="apellido" type="text" class="form-control{{ Session::has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{$usuario->usrApellido}}" required>

                        @if (Session::has('apellido'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('apellido') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group row">

                    <label for="tipoDocumento" class="col-md-2 col-form-label text-md-right">Tipo de Documento *</label>

                    <div class="col-md-4">
                        <select class="form-control" id="tipoDocumento" name="tipoDocumento">
                          <option value="CC" @if($usuario->usrTipoDocumento=="CC") selected @endif>Cédula de Ciudadanía</option>
                          <option value="CE" @if($usuario->usrTipoDocumento=="CE") selected @endif>Cédula de Extranjería</option>
                        </select>
                    </div>

                    <label for="cedula" class="col-md-2 col-form-label text-md-right">Número de Documento *</label>

                    <div class="col-md-4">
                        <input id="cedula" type="text" class="form-control{{ Session::has('cedula') ? ' is-invalid' : '' }}" name="cedula" value="{{$usuario->usrCedula}}" required>

                        @if (Session::has('cedula'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('cedula') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="ciudad" class="col-md-2 col-form-label text-md-right">Ciudad *</label>

                    <div class="col-md-4">
                      <select class="form-control" id="ciudad" name="ciudad">
                        <option value="Bogota" @if($usuario->usrCiudad=="Bogota") selected @endif>Bogotá</option>
                        <option value="Medellin" @if($usuario->usrCiudad=="Medellin") selected @endif>Medellín</option>
                        <option value="Cali" @if($usuario->usrCiudad=="Cali") selected @endif>Cali</option>
                      </select>
                    </div>

                    <label for="celular" class="col-md-2 col-form-label text-md-right">Celular *</label>

                    <div class="col-md-4">
                        <input id="celular" type="text" class="form-control{{ Session::has('celular') ? ' is-invalid' : '' }}" name="celular" value="{{$usuario->usrCelular}}" required>

                        @if (Session::has('celular'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ Session::get('celular') }}</strong>
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

                @if($usuario->rusrDescripcion!="Administrador")
                  <div class="form-group row">

                      <label for="rol" class="col-md-2 col-form-label text-md-right">Rol*</label>

                      <div class="col-md-4">
                          <select class="form-control" id="rol" name="rol">
                            @foreach($roles as $r)
                              <option value="{{$r->rusrID}}" @if($usuario->usrRolID==$r->rusrID) selected @endif>{{$r->rusrDescripcion}}</option>
                            @endforeach
                          </select>
                      </div>

                  </div>
                @endif



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
