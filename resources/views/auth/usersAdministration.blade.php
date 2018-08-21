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

          <script type= "text/javascript" src="{{ asset('js/jquery.js') }}"></script>
          <script type= "text/javascript" src="{{ asset('tab_divider/tab_divider.js') }}"></script>
          <script type= "text/javascript" src="{{ asset('tab_divider/tab_divider_bootstrap.js') }}"></script>
          <link rel= "stylesheet" href="{{ asset('tab_divider/tab_divider.css') }}">

          <table class="table table-hover" id="listaUsuarios">
            <thead>
              <tr class="table-secondary">
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Nombre de Usuario</th>
                <th>Rol</th>
                <th style="text-align:center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($usuarios as $u)
                  @if($u->usrActivo==1)<tr class="table-success">@else<tr class="table-danger">@endif
                    <td>{{$u->usrCedula}}</td>
                    <td>{{$u->usrNombre." ".$u->usrApellido}}</td>
                    <td>{{$u->usrUsuario}}</td>
                    <td>{{$u->rusrDescripcion}}</td>
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

          <script>
          $('#listaUsuarios').DataTable({
            ordering:false,
            paging: true,
            lengthMenu: [[8, 15, 30], [8, 15, 30]],
            language: {
               processing:     "Procesando...",
               search:         "Buscar&nbsp;:",
               lengthMenu:    "Ver _MENU_ elementos",
               info:           "Mostrando del elemento _START_ hasta el _END_ de _TOTAL_ elementos en total",
               infoEmpty:      "Mostrando del elemento 0 hasta el 0 de 0 elementos",
               infoFiltered:   "(filtrado de _MAX_ elementos)",
               infoPostFix:    "",
               loadingRecords: "Cargando...",
               zeroRecords:    "No se encontraron resultados",
               emptyTable:     "No hay registros en la tabla",
               paginate: {
                   first:      "Primero",
                   previous:   "<",
                   next:       ">",
                   last:       "Último"
               },
               aria: {
                   sortAscending:  ": activer pour trier la colonne par ordre croissant",
                   sortDescending: ": activer pour trier la colonne par ordre décroissant"
               }
           }
          });
          </script>


        </div>
    </div>
</div>
@endsection
