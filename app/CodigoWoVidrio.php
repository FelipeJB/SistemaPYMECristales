<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoWoVidrio extends Model
{
  protected $primaryKey  = 'cdgID';

  protected $fillable = [
      'cdgID', 'cdgMilimID', 'cdgColorID', 'cdgWO'
  ];
}
