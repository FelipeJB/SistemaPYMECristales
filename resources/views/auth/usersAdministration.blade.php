@extends('layouts.app')

@section('titulo', 'Administrar Usuarios')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Administrar Usuarios</li>
          </ol>

          <h2 class="section-title">Administrar Usuarios</h2>
          <p class="section-subtitle">A continuación se listan los usuarios registrados en el sistema.</p><br>

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

          <script type= "text/javascript" src="{{ asset('js/tab_divider.js') }}"></script>

          <table class="table table-hover">
            <thead>
              <tr class="table-secondary">
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Nombre de Usuario</th>
                <th>Rol</th>
                <th style="text-align:center">Acciones</th>
              </tr>
            </thead>
            <tbody id="listaUsuarios">
              @foreach($usuarios as $u)
                  @if($u->usrActivo==1)<tr class="table-success">@else<tr class="table-danger">@endif
                    <td>{{$u->usrCedula}}</td>
                    <td>{{$u->usrNombre." ".$u->usrApellido}}</td>
                    <td>{{$u->usrUsuario}}</td>
                    <td>{{$u->usrRolID}}</td>
                    <td align="center">
                      <a href="/EditarUsuario/{{$u->id}}" class='btn btn-info'>Editar</a>
                      @if($u->usrActivo==1)
                        <a href="/EliminarUsuario/{{$u->id}}" class='btn btn-danger'>Eliminar</a>
                      @else
                        <a href="/ActivarUsuario/{{$u->id}}" class='btn btn-success'>Activar</a>
                      @endif
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>

          @if (count($usuarios)>2)
             <ul class="pagination pagination-sm" id="myPager" style="float:right"></ul>
             <script>$('#listaUsuarios').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:2});</script>
          @endif

        </div>
    </div>
</div>
@endsection
