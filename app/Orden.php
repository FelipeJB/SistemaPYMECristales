<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
  protected $primaryKey  = 'ordID';

  protected $fillable = [
      'ordID', 'ordNumeroPedido', 'ordFecha', 'ordPuntoVentaID', 'ordVendedorID', 'ordClienteID', 'ordFormaPagoID', 'ordTotal', 'ordTotalCompra', 'ordAbono', 'ordSaldo', 'ordEstadoInstalacionID', 'ordRazonNegativa', 'ordFechaInstalacion', 'ordInstaladorID', 'ordObservaciones', 'ordMigrado'
  ];
}
