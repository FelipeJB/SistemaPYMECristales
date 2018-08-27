<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diseno extends Model
{
  protected $primaryKey  = 'dsnID';

  protected $fillable = [
      'dsnID', 'dsnCodigo', 'dsnDescripcion', 'pvActivo'
  ];
}
