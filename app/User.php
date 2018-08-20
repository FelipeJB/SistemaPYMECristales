<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usrNombre', 'usrUsuario', 'password', 'usrRolID', 'usrCedula', 'usrApellido', 'usrTipoDocumento', 'usrActivo', 'usrCiudad', 'usrFechaCreacion', 'usrCelular', 'usrDireccion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
