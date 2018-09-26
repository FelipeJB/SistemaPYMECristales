@extends('layouts.app')

@section('titulo', 'Ventas')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Ver Ventas</li>
          </ol>

          <h2 class="section-title">Ventas</h2>
          <p class="section-subtitle">A continuación se muestran todas las ventas registradas en el sistema.</p><br>

          <script type= "text/javascript" src="{{ asset('js/jquery.js') }}"></script>
          <script type= "text/javascript" src="{{ asset('tab_divider/tab_divider.js') }}"></script>
          <script type= "text/javascript" src="{{ asset('tab_divider/tab_divider_bootstrap.js') }}"></script>
          <link rel= "stylesheet" href="{{ asset('tab_divider/tab_divider.css') }}">

          <table class="table table-hover" id="listaInstaladores">
            <thead>
              <tr class="table-secondary">
                <th># Orden</th>
                <th>Cédula Cliente</th>
                <th>Nombre Cliente</th>
                <th>Fecha</th>
                <th>Precio</th>
                <th style="text-align:center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ordenes as $o)
                <tr>
                    <td>{{$o->ordID}}</td>
                    <td>{{$o->cltCedula}}</td>
                    <td>{{$o->cltNombre ." ". $o->cltApellido}}</td>
                    <td>{{$o->ordFecha}}</td>
                    <td>{{$o->ordTotal}}</td>
                    <td align="center">
                      <a href="/Ventas/{{$o->ordID}}" class='btn btn-info'>Ver</a>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <hr>
          <script>
          $('#listaInstaladores').DataTable({
            ordering:true,
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

        </div>
    </div>
</div>
@endsection
