@extends('layouts.app')

@section('titulo', 'Administrar Milimetrajes')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            <li class="breadcrumb-item active">Administrar Milimetrajes</li>
          </ol>

          <h2 class="section-title">Administrar Milimetrajes</h2>
          <p class="section-subtitle">A continuación se listan los milimetrajes registrados en el sistema.</p><br>

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

          <table class="table table-hover" id="listaMilimetrajes">
            <thead>
              <tr class="table-secondary">
                <th>Número</th>
                <th style="text-align:center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($milimetrajes as $m)
                  @if($m->mlmActivo==1)<tr class="table-success">@else<tr class="table-danger">@endif
                    <td>{{$m->mlmNumero}} mm</td>
                    <td align="center">
                      <a href="/EditarMilimetraje/{{$m->mlmID}}" class='btn btn-info'>Editar</a>
                      @if($m->mlmActivo==1)
                        <a href="/EliminarMilimetraje/{{$m->mlmID}}" class='btn btn-danger'>Eliminar</a>
                      @else
                        <a href="/ActivarMilimetraje/{{$m->mlmID}}" class='btn btn-success'>Activar</a>
                      @endif
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>

          <script>
          $('#listaMilimetrajes').DataTable({
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

          <br><br><a href="/CrearMilimetraje" class='btn btn-success' style="float:right;">Agregar Milimetraje</a>
          <br><br><hr>

        </div>
    </div>
</div>
@endsection
