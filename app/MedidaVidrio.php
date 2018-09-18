<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedidaVidrio extends Model
{
  protected $primaryKey  = 'mvdID';

  protected $fillable = [
      'mvdID', 'mvdOrddID', 'mvdOrdID', 'mvdAlto', 'mvdAncho', 'mvdCantPerforaciones', 'mvdCantBoquetes', 'mvdCantBPB', 'mvdCantChaflan', 'mvdTipo'
  ];
}
