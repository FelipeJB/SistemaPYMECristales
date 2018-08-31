<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecioVidrio extends Model
{
  protected $primaryKey  = 'pvdID';

  protected $fillable = [
      'pvdID', 'pvdMilimID', 'pvdSistemaID', 'pvdPrecioVenta', 'pvdPrecioCompra'
  ];
}
