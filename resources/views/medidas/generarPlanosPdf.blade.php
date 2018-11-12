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
          <th width="50%">
            <img src="img/Logo-reportes.png" width="350" align="center">
          </th>
          <td align="center" width="50%">
            <b>Cristales Templados La Torre S.A.S</b><br>
            <b>Nit 900593026-1</b><br><br>
            <b>Cumplimiento de garantía:</b>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="column">
    </div>
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
          <b>{{$cliente->cltNombre}} {{$cliente->cltApellido}}</b><br>
          <b>{{$cliente->cltTipoDocumento}} {{$cliente->cltCedula}}</b><br>
          <b>{{$cliente->cltDireccion}} {{$cliente->cltCiudad}}</b><br>
          <b>{{$cliente->cltCelular1}}</b><br>
          <b>{{$formaPago->fpDescripcion}}</b>
        </td>
      </tr>
    </table>
  </div>
</div>
</body>
</html>
