<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instalador extends Model
{
  protected $fillable = [
      'insId', 'insNombre', 'insApellido', 'insTipoDocumento', 'insCedula', 'insCiudad', 'insFechaCreacion', 'insCelular', 'insDireccion', 'insActivo'
  ];
}
