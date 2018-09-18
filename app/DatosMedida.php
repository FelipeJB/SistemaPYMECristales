<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosMedida extends Model
{
  protected $fillable = [
      'esPositiva', 'razonNegativa', 'esBatiente', 'esCompuesto', 'ladoPuerta', 'alto', 'ancho1', 'ancho2', 'anchoPuerta', 'observaciones', 'idDetalle'
  ];
}
