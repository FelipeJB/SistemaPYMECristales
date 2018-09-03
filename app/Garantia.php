<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
  protected $primaryKey  = 'grnID';

  protected $fillable = [
      'grnID', 'grnFecha', 'grnOrdenID', 'grnObservaciones'
  ];
}
