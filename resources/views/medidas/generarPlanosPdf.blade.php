<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Toma de medidas de Orden Detalle N{{$detalle->orddID}}</title>
    <style>
    body{
      margin-top: 1px;
    }
    table{
      border-collapse: collapse;
      padding-top: 10px;
      padding-bottom: 10px;
    }
    th, td, p, b{
      font-size: 13px;
      font-family: sans-serif;
    }

    th, td{
      padding-top: 5px;
      padding-bottom: 5px;
      padding-left: 5px;
      padding-right: 5px;
    }
    p{
      line-height: 3px;
    }
    </style>

</head>
<body>
  <div class="row">
    <div class="column">
      <table border="0" width="100%">
        <tr>
          <th width="100%" align="left">
            <img src="img/Logo-reportes.png" width="250" align="left">
          </th>
        </tr>
        <tr>
          <td align="center" width="100%">
            <br><b>Cristales Templados La Torre S.A.S</b><br>
            <b>Formato de planos</b>
          </td>
        </tr>
        <tr>
          <td width="50%">
          </td>
          <td width="50%" align="left">
            <b>Código: FOR-CM-08 Versión: 2 Fecha: 01/04/2018</b>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="column">
    <table border="1" align="center" width="100%">
      <tr>
        <td align="right" width="20%">
          <b>Auxiliar logístico:</b><br>
          <b>Nombre del cliente:</b><br>
          <b>Número de la OP:</b><br>
          <b>Sistema:</b><br>
          <b>Color:</b><br>
          <b>Espesor:</b><br>
          <b>Talla:</b><br>
          <b>Precio total:</b>
        </td>
        <td align="left" width="80%">
          <b>{{$auxiliar->usrNombre}} {{$auxiliar->usrApellido}}</b><br>
          <b>{{$cliente->cltNombre}} {{$cliente->cltApellido}}</b><br>
          <b>{{$orden->ordNumeroPedido}} / Item {{$detalle->orddItem}}</b><br>
          <b>{{$sistema->stmDescripcion}}</b><br>
          <b>{{$color->clrDescripcion}}</b><br>
          <b>{{$milimetraje->mlmNumero}} mm</b><br>
          <b>NA</b><br>
          <b>{{$detalle->orddTotal}}</b>
        </td>
      </tr>
    </table>
  </div>
</div>
<div class="row">
  <div class="column">
    <table border="0" width="100%">
      <tr>
        <th width="100%" align="center">
          <img src={{$imagen}} width="450" align="center">
        </th>
      </tr>
    </table>
  </div>
</div>
<div class="row">
  <div class="column">
    <table border="0" width="100%">
      <tr>
        <th width="27%" align="center">
          Medida 1 = {{$vidrioF->mvdAlto}} mm
        </th>
        <th width="27%" align="center">
          Medida 2 = {{$vidrioF->mvdAnchoArriba}} mm
        </th>
        <th width="27%" align="center">
          Medida 3 = {{$vidrioF->mvdAnchoAbajo}} mm
        </th>
        <th width="19%" align="left">
          FIJO
        </th>
      </tr>
      <tr>
        <th width="27%" align="center">
          Medida 4 = {{$vidrioP->mvdAlto}} mm
        </th>
        <th width="27%" align="center">
          Medida 5 = {{$vidrioP->mvdAnchoArriba}} mm
        </th>
        <th width="27%" align="center">
          Medida 6 = {{$vidrioP->mvdAnchoAbajo}} mm
        </th>
        <th width="19%" align="left">
          PUERTA
        </th>
      </tr>
    </table>
  </div>
</div>
<br><b>Observaciones: <b><br>
  @if($detalle->orddObservaciones != null && $detalle->orddObservaciones != '' && $detalle->orddObservaciones != 'undefined')
<b>     {{$detalle->orddObservaciones}}<b><br>
  @endif
<b>     {{$detalle->orddObservacionesVidrio}}<b><br>
</body>
</html>
