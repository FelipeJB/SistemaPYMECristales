<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Orden de Pedido N{{$orden->ordNumeroPedido}}</title>
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

        </div>
        <div class="column">
            <table border="0" width="100%">
              <tr>
                <th width="50%">
                  <img src="img/Logo-reportes.png" width="350" align="center">
                </th>
                <td align="center" width="50%">
                  <b>Cristales Templados La Torre S.A.S</b><br>
                  <b>Nit 900593026-1</b>
                  <p>www.cristalestemplados.com.co</p>
                  <p>contacto@cristalestempladoslatorre.com</p>
                  <p>Calle 37s sur Nro 68d-36 Alquería la Fragua</p>
                  <p>Teléfonos: 8053239 - 3202607199</p>
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
            <th align="center" width="15%">Fecha</th>
            <th align="center" width="30%">Punto de Venta</th>
            <th align="center" width="40%">Vendedor</th>
            <th align="center" width="15%">Orden de Pedido Nro</th>
          </tr>
          <tr>
            <th align="center" width="15%">{{$orden->ordFecha}}</th>
            <th align="center" width="30%">{{$puntoVenta->pvNombre}} ({{$puntoVenta->pvDireccion}}, {{$vendedor->usrCiudad}}) Cel: {{$vendedor->usrCelular}}</th>
            <th align="center" width="40%">{{$vendedor->usrNombre}}</th>
            <th align="center" width="15%">{{$orden->ordNumeroPedido}}</th>
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
        <table border="1" align="center" width="100%">
          <tr>
            <td align="right" width="20%">
              <b>Nombre del Cliente:</b><br>
              <b>Documento:</b><br>
              <b>Dirección y ciudad:</b><br>
              <b>Teléfonos:</b><br>
              <b>Forma de pago:</b>
            </td>
            <td align="left" width="80%">
              <b>{{$cliente->cltNombre}}</b><br>
              <b>{{$cliente->cltTipoDocumento}} {{$cliente->cltCedula}}</b><br>
              <b>{{$cliente->cltDireccion}} {{$cliente->cltCiudad}}</b><br>
              <b>{{$cliente->cltCelular1}}</b><br>
              <b>{{$formaPago->fpDescripcion}}</b>
            </td>
          </tr>
        </table>
      </div>
      </div>
      <div class="row">
        <div class="column">
        <table border="1" align="center" width="100%">
          <tr>
            <th align="center" width="8%">Item</th>
            <th align="center" width="8%">Cant.</th>
            <th align="center" width="45%">Descripción</th>
            <th align="center" width="8%">Alto (mm)</th>
            <th align="center" width="8%">Ancho (mm)</th>
            <th align="center" width="8%">Dcto.</th>
            <th align="center" width="15%">Total</th>
          </tr>
          @foreach($detalles as $d)
          <tr>
            <th align="center" width="8%">{{$d->orddItem}}</th>
            <th align="center" width="8%">{{$d->orddCantVidrio}}</th>
            <th align="center" width="45%">{{$sistemas[$d->orddItem-1]->stmDescripcion}} {{$milimetrajes[$d->orddItem-1]->mlmNumero}} mm {{$colores[$d->orddItem-1]->clrDescripcion}} Diseño: {{$disenos[$d->orddItem-1]->dsnDescripcion}} Toalleros: {{$d->orddCantToalleros}}</th>
            <th align="center" width="8%">{{$d->orddAlto}}</th>
            <th align="center" width="8%">{{$d->orddAncho}}</th>
            <th align="center" width="8%">{{$d->orddDescuento}}%</th>
            <th align="center" width="15%">$ <?php echo number_format($d->orddTotal,0,",",".");?></th>
          </tr>
          @endforeach
        </table>
      </div>
      </div>
      <div class="row">
        <div class="column">
        <table border="1" align="center" width="100%">
          <tr>
            <th align="right" valign="top" width="70%" rowspan="3">Observaciones:{{$observaciones}}</th>
            <th align="right" width="18%">Total (COP $):</th>
            <th align="right" width="12%">$ <?php echo number_format($orden->ordTotal,0,",",".");?></th>
          </tr>
          <tr>
            <th align="right" width="18%">Abono (COP $):</th>
            <th align="right" width="12%">$ <?php echo number_format($orden->ordAbono,0,",",".");?></th>
          </tr>
          <tr>
            <th align="right" width="18%">Saldo (COP $):</th>
            <th align="right" width="12%">$ <?php echo number_format($orden->ordSaldo,0,",",".");?></th>
          </tr>
        </table>
      </div>
      </div>
      <div class="row">
        <div class="column">
          <b></b><br>
          <b align="left">___________________</b><br>
          <b padding-top=0px align="left">Cliente</b><br>
          <b padding-top=0px align="left">CC</b><br><br>

        <table border="0" align="left" width="100%">
          <tr>
            <td width="100%">
              <b>Nota:</b><br>
              <b>1. El precio indicado en este documento puede variar luego de ser efectuada la toma de medidas.</b><br>
              <b>2. En caso de una variación en el precio pactado inicialmente, a la hora de la toma de medidas, le será notificado el nuevo
  precio. Para iniciar la producción usted deberá aceptar el nuevo precio calculado.</b><br>
              <b>3. La entrega e instalación de los productos será efectuada dentro de los 8 días hábiles siguientes a la toma de medidas,
  la cual será efectuada dentro de los 2 días hábiles siguientes a la compra.</b><br>
              <b>4. Para que la garantía sea válida es necesario que el cliente diligencie el formato de entrega y satisfacción entregado por
  el instalador al momento de la entrega del producto.</b>
            </td>
          </tr>
        </table>
      </div>
      </div>
</body>
</html>
