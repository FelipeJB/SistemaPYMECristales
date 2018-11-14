<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Informe de Garantías {{$mes}}-{{$anio}}</title>
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
            <b>Informe de Garantías {{$mes}}-{{$anio}}</b><br>
          </td>
        </tr>
      </table>
    </div>
  </div>
<hr>
  <div class="row">
    <div class="column">
      @for($i = 0; $i < count($instaladorGarantias); $i++)
      <table border="0" align="center" width="100%">
        <tr>
          <th width="100%" align="left">
            Instalador: {{$instaladorGarantias[$i]['insNombre']}} {{$instaladorGarantias[$i]['insApellido']}}
          </th>
        </tr>
      </table>
      <table border="1" align="center" width="100%">
        <tr>
          <th width="100%" align="left" colspan="4">
            Garantías registradas: {{$instaladorGarantias[$i]['totalInstalador']}}
          </th>
        </tr>
        @if($instaladorGarantias[$i]['totalInstalador'] > 0)
        <tr>
          <th width="25%" align="center">
            Número de Pedido
          </th>
          <th width="25%" align="center">
            Observaciones
          </th>
          <th width="25%" align="center">
            Fecha garantía
          </th>
          <th width="25%" align="center">
            Total Orden
          </th>
        </tr>
        @for($j = 0; $j < count($instaladorGarantias[$i]['ordenes']); $j++)
          <tr>
            <td width="25%" align="center">
              {{$instaladorGarantias[$i]['ordenes'][$j]->ordNumeroPedido}}
            </td>
            <td width="25%" align="center">
              {{$instaladorGarantias[$i]['ordenes'][$j]->grnObservaciones}}
            </td>
            <td width="25%" align="center">
              {{$instaladorGarantias[$i]['ordenes'][$j]->grnFecha}}
            </td>
            <td width="25%" align="center">
              $ <?php echo number_format($instaladorGarantias[$i]['ordenes'][$j]->ordTotal,0,",",".");?>
            </td>
          </tr>
        @endfor
        @endif
      </table>
      @endfor
      <hr>
      <table border="0" align="center" width="100%">
        <tr>
          <th width="100%" align="left">
            TOTAL GARANTÍAS REGISTRADAS EN EL MES: {{$totalMes}}
          </th>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>
