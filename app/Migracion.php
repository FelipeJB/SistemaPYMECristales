<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Migracion extends Model
{
  protected $primaryKey  = 'mgcID';

  protected $fillable = [
      'mgcID', 'mgcFecha'
  ];
}
