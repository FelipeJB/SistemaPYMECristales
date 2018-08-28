<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
  protected $primaryKey  = 'clrID';

  protected $fillable = [
      'clrID', 'clrCodigo', 'clrDescripcion', 'clrPrecioVenta', 'clrPrecioCompra', 'clrActivo'
  ];
}
