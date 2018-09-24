<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sistema extends Model
{
  protected $primaryKey  = 'stmID';

  protected $fillable = [
      'stmID', 'stmTipo', 'stmCodigoWO', 'stmDescripcion', 'stmPrecioVenta', 'stmPrecioCompra', 'stmActivo', 'stmCantPerforaciones', 'stmCantBoquetes', 'stmCantBPB', 'stmCantChaflan'
  ];
}
