<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
  protected $primaryKey  = 'stdID';

  protected $fillable = [
      'stdID', 'stdDescripcion'
  ];
}
