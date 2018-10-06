<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ordenes</title>
    <style>
    table{
      border-collapse: collapse;
      padding-top: 10px;
      padding-bottom: 10px;
    }

    </style>

</head>
<body>

      <div class="row">
        <div class="column">

        </div>
        <div class="column">
            <table border="0" width="100%" margin-bottom=20px font-size=13px font-family="Arial">
              <tr>
                <th width="50%">
                </th>
                <th align="center" width="50%">Cristales Templados La Torre S.A.S</th>
              </tr>
              <tr>
                <th width="50%">
                </th>
                <th align="center" width="50%">Nit 900593026-1</th>
              </tr>
              <tr>
                <td width="50%">
                </td>
                <td align="center" width="50%">www.cristalestemplados.com.co</td>
              </tr>
              <tr>
                <td width="50%">
                </td>
                <td align="center" width="50%">contacto@cristalestempladoslatorre.com</td>
              </tr>
              <tr>
                <td width="50%">
                </td>
                <td align="center" width="50%">Calle 37s sur Nro 68d-36 Alquería la Fragua</td>
              </tr>
              <tr>
                <td width="50%">
                </td>
                <td align="center" width="50%">Teléfonos: 8053239 - 3202607199</td>
              </tr>
            </table>
        </div>
      </div>
      <div class="row">
        <div class="column">
        </div>
        <div class="column">
        <table border="1" align="center" width="100%" margin-top=20px  font-size=13px style="font-family:Calibri;">
          <tr>
            <th align="center">Fecha</th>
            <th align="center">Punto de Venta</th>
            <th align="center">Vendedor</th>
            <th align="center">Orden de Pedido Nro</th>
          </tr>
          <tr>
            <td align="center" width="10%">{{$orden->ordFecha}}</td>
            <td align="center" width="30%">{{$puntoVenta->pvNombre}}</td>
            <td align="center" width="50%">{{$vendedor->usrNombre}}</td>
            <td align="center" width="10%">{{$orden->ordNumeroPedido}}</td>
          </tr>
        </table>
      </div>
      </div>
      <div class="row">
      </div>
      <div class="row">
        <div class="column">
        </div>
        <div class="column">
        <table border="1" align="center" width="100%" margin-top=20px  font-size=13px style="font-family:Calibri;">
          <tr>
            <th align="right" width="30%">Nombre del Cliente:</th>
            <td align="left" width="70%">{{$cliente->cltNombre}}</td>
          </tr>
          <tr>
            <th align="right" width="30%" border="0">Documento:</th>
            <td align="left" width="70%" border="0">{{$cliente->cltCedula}}</td>
          </tr>
          <tr>
            <th align="right" width="30%" border="0">Dirección y ciudad:</th>
            <td align="left" width="70%" border="0">{{$cliente->cltDireccion}}</td>
          </tr>
          <tr>
            <th align="right" width="30%" border="0">Teléfonos:</th>
            <td align="left" width="70%" border="0">{{$cliente->cltCelular1}}</td>
          </tr>
          <tr>
            <th align="right" width="30%">Forma de pago:</th>
            <td align="left" width="70%">{{$formaPago->fpDescripcion}}</td>
          </tr>
        </table>
      </div>
      </div>
      <div class="row">
        <div class="column">
        <table border="1" align="center" width="100%" margin-top=20px  font-size=13px style="font-family:Calibri;">
          <tr>
            <th align="center">Item</th>
            <th align="center">Cant.</th>
            <th align="center">Descripción</th>
            <th align="center">Alto (mm)</th>
            <th align="center">Ancho (mm)</th>
            <th align="center">Dcto.</th>
            <th align="center">Total</th>
          </tr>
          <p id="cont"></p>

          <script>
          var count = 0;
          </script>

          @foreach($detalles as $d)
          <script>
          count = count + 1;
          </script>
          <tr>
            <td align="center" width="10%"><script>document.getElementById("cont").innerHTML = count</script></td>
            <td align="center" width="10%">{{$d->orddCantVidrio}}</td>
            <td align="center" width="40%">{{$d->orddCantVidrio}}</td>
            <td align="center" width="10%">{{$d->orddAlto}}</td>
            <td align="center" width="10%">{{$d->orddAncho}}</td>
            <td align="center" width="10%">{{$d->orddDescuento}}</td>
            <td align="center" width="10%">{{$d->orddCantVidrio}}</td>
          </tr>
          @endforeach
        </table>
      </div>
      </div>
      <div class="row">
        <div class="column">
        <table border="1" align="center" width="100%" margin-top=20px  font-size=13px style="font-family:Calibri;">
          <tr>
            <td align="center" width="60%">Observaciones:</td>
            <td align="center" width="40%">
              <tr>
                <td align="right" width="20%">Total (COP $):</td>
                <td align="center" width="20%">{{$orden->ordTotal}}</td>
              </tr>
              <tr>
                <td align="right" width="20%">Abono (COP $):</td>
                <td align="center" width="20%">{{$orden->ordAbono}}</td>
              </tr>
              <tr>
                <td align="right" width="20%">Saldo (COP $):</td>
                <td align="center" width="20%">{{$orden->ordSaldo}}</td>
              </tr>
            </td>
          </tr>

        </table>
      </div>
      </div>
      <div class="row">
        <div class="column">
          <p align="left">___________________</p>
          <p padding-top=0px align="left">Cliente</p>
          <p padding-top=0px align="left">CC</p>

        <table border="0" align="left" width="100%" margin-top=20px  font-size=13px style="font-family:Calibri;">
          <tr>
            <td>Nota:</td>
          </tr>
          <tr>
            <td>1. El precio indicado en este documento puede variar luego de ser efectuada la toma de medidas.</td>
          </tr>
          <tr>
            <td>2. En caso de una variación en el precio pactado inicialmente, a la hora de la toma de medidas, le será notificado el nuevo
precio. Para iniciar la producción usted deberá aceptar el nuevo precio calculado.</td>
          </tr>
          <tr>
            <td>3. La entrega e instalación de los productos será efectuada dentro de los 8 días hábiles siguientes a la toma de medidas,
la cual será efectuada dentro de los 2 días hábiles siguientes a la compra.</td>
          </tr>
          <tr>
            <td>4. Para que la garantía sea válida es necesario que el cliente diligencie el formato de entrega y satisfacción entregado por
el instalador al momento de la entrega del producto.</td>
          </tr>
        </table>
      </div>
      </div>
</body>
</html>
