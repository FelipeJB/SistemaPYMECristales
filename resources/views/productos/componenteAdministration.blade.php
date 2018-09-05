@extends('layouts.app')

@section('titulo', 'Elementos de Sistema')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/AdministrarSistemas">Administrar Sistemas</a></li>
            <li class="breadcrumb-item active">Elementos de Sistema</li>
          </ol>

          <h2 class="section-title">Elementos del Sistema: {{$sistema->stmDescripcion}}</h2>
          <p class="section-subtitle">A continuación se listan los elementos del sistema.</p><br>

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

          <table class="table table-hover" id="listaComponentes">
            <thead>
              <tr class="table-secondary">
                <th>Código World Office</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th style="text-align:center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($componentes as $c)
                  @if($c->stmdActivo==1)<tr class="table-success">@else<tr class="table-danger">@endif
                    <td>{{$c->stmdCodigoWO}}</td>
                    <td>{{$c->stmdDescripcion}}</td>
                    <td>{{$c->stmdCantidad}}</td>
                    <td align="center">
                      <a href="/EditarElemento/{{$c->stmdID}}" class='btn btn-info'>Editar</a>
                      @if($c->stmdActivo==1)
                        <a href="/EliminarElemento/{{$sistema->stmID}}/{{$c->stmdID}}" class='btn btn-danger'>Eliminar</a>
                      @else
                        <a href="/ActivarElemento/{{$sistema->stmID}}/{{$c->stmdID}}" class='btn btn-success'>Activar</a>
                      @endif
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>

          <script>
          $('#listaComponentes').DataTable({
            ordering:false,
            paging: true,
            lengthMenu: [[8, 15, 30], [8, 15, 30]],
            language: {
               processing:     "Procesando...",
               search:         "Buscar&nbsp;:",
               lengthMenu:    "Ver _MENU_ elementos",
               info:           "Mostrando del elemento _START_ hasta el _END_ de _TOTAL_ en total",
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

          <br><br><a href="/CrearElemento/{{$sistema->stmID}}" class='btn btn-success' style="float:right;">Agregar Elemento</a>
          <br><br><hr>
          
        </div>
    </div>
</div>
@endsection
