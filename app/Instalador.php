<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instalador extends Model
{
  protected $primaryKey  = 'insID';

  protected $fillable = [
      'insID', 'insNombre', 'insApellido', 'insTipoDocumento', 'insCedula', 'insCiudad', 'insFechaCreacion', 'insCelular', 'insDireccion', 'insActivo'
  ];
}
