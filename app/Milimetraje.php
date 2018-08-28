<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milimetraje extends Model
{
  protected $primaryKey  = 'mlmID';

  protected $fillable = [
      'mlmID', 'mlmNumero', 'mlmActivo'
  ];
}
