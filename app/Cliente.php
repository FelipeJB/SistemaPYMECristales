<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
  protected $primaryKey  = 'cltID';

  protected $fillable = [
      'cltID', 'cltNombre', 'cltApellido', 'cltEmail', 'cltTipoDocumento', 'cltCedula', 'cltCiudad', 'cltFechaCreacion', 'cltCelular1', 'cltCelular2', 'cltDireccion', 'cltTipoCliente', 'cltTarifaICA', 'cltUsuarioCreador', 'cltMigrado'
  ];
}
