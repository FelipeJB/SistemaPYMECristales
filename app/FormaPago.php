<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
  protected $primaryKey  = 'fpID';

  protected $fillable = [
      'fpID', 'fpDescripcion'
  ];
}
