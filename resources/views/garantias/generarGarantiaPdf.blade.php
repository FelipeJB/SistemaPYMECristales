<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Garantía de Orden N{{$orden->ordNumeroPedido}}</title>
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
      <table border="0" align="left" width="100%">
        <tr>
          <th width="100%">
            <br><br>
            <b>Fecha de solicitud: {{$garantia->created_at}}</b><br><br>
            <b>Cliente: {{$cliente->cltNombre}} {{$cliente->cltApellido}}</b><br><br>
            <b>Número de Factura: {{$orden->ordNumeroPedido}}</b><br><br>
            <b>Teléfonos: {{$cliente->cltCelular1}}</b><br><br>
            <b>Dirección: {{$cliente->cltDireccion}}, {{$cliente->cltCiudad}}</b><br><br>
            <b>Instalador/a: {{$instalador->insNombre}} {{$instalador->insApellido}}</b><br><br>
            <b>Vendedor/a: {{$vendedor->usrNombre}} {{$vendedor->usrApellido}}</b><br><br>
            <b>Observaciones: {{$garantia->grnObservaciones}}</b><br><br><br><br>
            <b>Fecha de programación:</b><br><br><br>
            <b>Recibí a satisfacción la garantía realizada</b><br><br><br><br>
            <b>______________________</b>
          </th>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>
