<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenDetalle extends Model
{
  protected $primaryKey  = 'orddID';

  protected $fillable = [
      'orddID', 'orddOrdenID', 'orddItem', 'orddDescuento', 'orddTotal', 'orddTotalCompra', 'orddCantVidrio', 'orddCantToalleros', 'orddSistemaID', 'orddMilimID',
       'orddColorID', 'orddDisenoID', 'orddEstadoMedidasID', 'orddRazonNegativa', 'orddFechaMedidas', 'orddAuxiliarID', 'orddObservaciones', 'orddAlto', 'orddAncho',
        'orddRelacion', 'orddValorAdicional', 'orddDescripcionAdicional', 'orddLadoPuerta', 'orddObservacionesVidrio', 'orddDescuadre'
  ];
}
