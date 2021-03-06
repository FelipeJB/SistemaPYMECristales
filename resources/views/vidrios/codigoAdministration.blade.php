@extends('layouts.app')

@section('titulo', 'Administrar Códigos')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Administrar Códigos</li>
          </ol>

          <h2 class="section-title">Administrar Códigos World Office</h2>
          <p class="section-subtitle">A continuación se listan los códigos de World Office por cada vidrio con color y milimetraje activos.</p><br>

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

          <table class="table table-hover" id="listaCodigos">
            <thead>
              <tr class="table-secondary">
                <th>Color</th>
                <th>Milimetraje</th>
                <th>Código World Office</th>
                <th style="text-align:center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($codigos as $c)
                <tr>
                    <td>{{$c->clrDescripcion}}</td>
                    <td>{{$c->mlmNumero}}</td>
                    <td>{{$c->cdgWO}}</td>
                    <td align="center">
                      <a href="/EditarCodigo/{{$c->cdgID}}" class='btn btn-info'>Editar</a>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          <script>
          $('#listaCodigos').DataTable({
            ordering: true,
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
                   sortAscending:  ": activar para ordenar la columna en orden ascendente",
                   sortDescending: ": activar para ordenar la columna en orden descendiente"
               }
           }
          });
          </script>

        </div>
    </div>
</div>
@endsection
