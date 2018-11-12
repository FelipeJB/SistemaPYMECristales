<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Informe de Ventas {{$mes}}-{{$anio}}</title>
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
          <th width="50%">
            <img src="img/Logo-reportes.png" width="350" align="center">
          </th>
          <td align="center" width="50%">
            <b>Cristales Templados La Torre S.A.S</b><br>
            <b>Nit 900593026-1</b><br><br>
            <b>Informe de Ventas {{$mes}}-{{$anio}}</b><br>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="column">
      @for($i = 0; $i < count($puntoOrdenes); $i++)
      <table border="1" align="center" width="100%">
        <tr>
          <th width="100%" align="left" colspan="4">
            Punto de Venta: {{$puntoOrdenes[$i]['puntoVenta']}}
          </th>

        </tr>
        <tr>
          <th width="25%" align="center">
            Número de Orden
          </th>
          <th width="25%" align="center">
            Total Venta
          </th>
          <th width="25%" align="center">
            Total Compra
          </th>
          <th width="25%" align="center">
            Total Utilidades
          </th>
        </tr>
        @for($j = 0; $j < count($puntoOrdenes[$i]['ordenes']); $j++)
        <tr>
          <td width="25%" align="center">
            {{$puntoOrdenes[$i]['ordenes'][$j]->ordNumeroPedido}}
          </td>
          <td width="25%" align="center">
            {{$puntoOrdenes[$i]['ordenes'][$j]->ordTotal}}
          </td>
          <td width="25%" align="center">
            {{$puntoOrdenes[$i]['ordenes'][$j]->ordTotalCompra}}
          </td>
          <td width="25%" align="center">
            {{$puntoOrdenes[$i]['ordenes'][$j]->ordTotalUtilidades}}
          </td>
        </tr>
        @endfor
        <tr>
          <th width="100%" align="left" colspan="4">
            Total Ventas: {{$puntoOrdenes[$i]['totalPuntoVenta']}}
          </th>
        </tr>
      </table>
      @endfor
    </div>
  </div>
</body>
</html>
