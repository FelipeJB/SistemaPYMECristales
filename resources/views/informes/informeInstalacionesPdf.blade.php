<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Informe de Instalaciones {{$mes}}-{{$anio}}</title>
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
            <b>Informe de Instalaciones {{$mes}}-{{$anio}}</b><br>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="column">
      @for($i = 0; $i < count($instaladorOrdenes); $i++)
      <table border="0" align="center" width="100%">
        <tr>
          <th width="100%" align="left">
            Instalador: {{$instaladorOrdenes[$i]['insNombre']}} {{$instaladorOrdenes[$i]['insApellido']}}
          </th>
        </tr>
      </table>
      <table border="1" align="center" width="100%">
        <tr>
          <th width="100%" align="left" colspan="3">
            Instalaciones programadas: {{$instaladorOrdenes[$i]['totalInstaladorSI']}}
          </th>
        </tr>
        @if($instaladorOrdenes[$i]['totalInstaladorSI'] > 0)
        <tr>
          <th width="33%" align="center">
            Número de Pedido
          </th>
          <th width="34%" align="center">
            Fecha de Instalación
          </th>
          <th width="33%" align="center">
            Total Orden
          </th>
        </tr>
        @for($j = 0; $j < count($instaladorOrdenes[$i]['ordenes']); $j++)
          @if($instaladorOrdenes[$i]['ordenes'][$j]->ordEstadoInstalacionID == 4)
          <tr>
            <td width="33%" align="center">
              {{$instaladorOrdenes[$i]['ordenes'][$j]->ordNumeroPedido}}
            </td>
            <td width="34%" align="center">
              {{$instaladorOrdenes[$i]['ordenes'][$j]->ordFechaInstalacion}}
            </td>
            <td width="33%" align="center">
              ${{number_format($instaladorOrdenes[$i]['ordenes'][$j]->ordTotal)}}
            </td>
          </tr>
          @endif
        @endfor
        @endif
      </table>
      @endfor
      <hr>
      <table border="0" align="center" width="100%">
        <tr>
          <th width="100%" align="left">
            TOTAL INSTALACIONES PROGRAMADAS EN EL MES: {{$totalMesSi}}
          </th>
        </tr>
      </table>
      <hr>
      <table border="1" align="center" width="100%">
        <tr>
          <th width="100%" align="left" colspan="4">
            Instalaciones NO programadas: {{count($ordenesNO)}}
          </th>
        </tr>
        @if({{count($ordenesNO)}} > 0)
        <tr>
          <th width="25%" align="center">
            Número de Pedido
          </th>
          <th width="25%" align="center">
            Fecha
          </th>
          <th width="25%" align="center">
            Motivo
          </th>
          <th width="25%" align="center">
            Total Orden
          </th>
        </tr>
        @for($j = 0; $j < count($ordenesNO); $j++)
          <tr>
            <td width="25%" align="center">
              {{$ordenesNO[$j]->ordNumeroPedido}}
            </td>
            <td width="25%" align="center">
              {{date("d-m-Y",strToTime($ordenesNO[$j]->ordFechaInstalacion))}}
            </td>
            <td width="25%" align="center">
              {{$ordenesNO[$j]->ordRazonNegativa}}
            </td>
            <td width="25%" align="center">
              ${{number_format($ordenesNO[$j]->ordTotal)}}
            </td>
          </tr>
        @endfor
        @endif
      </table>
      <hr>
    </div>
  </div>
</body>
</html>
