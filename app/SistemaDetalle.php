<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SistemaDetalle extends Model
{
  protected $primaryKey  = 'stmdID';

  protected $fillable = [
      'stmdID', 'stmdSistemaID', 'stmdCodigoWO', 'stmdDescripcion', 'stmdCantidad', 'stmdActivo'
  ];
}
