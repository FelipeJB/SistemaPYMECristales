<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuntoVenta extends Model
{
  protected $primaryKey  = 'pvID';

  protected $fillable = [
      'pvID', 'pvNombre', 'pvDireccion', 'pvActivo'
  ];
}
