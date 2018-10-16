<?php

namespace App\Http\Controllers\Migraciones;

use App\Orden;
use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MigracionController extends Controller
{

  public function create()
  {
    /*Se guardan los datos de la migración dentro de variables desde el formulario*/
    $tipo = Input::get('tipo');

    //verificar tipo de migración
    if($tipo == 0){
      //caso en el cual se migran todos los datos no migrados

      $this->generateMigrationTerceros()
    }else{
      //caso en el cual se repite una migración

    }

    return Redirect::back()->with('success', 'Archivos de migración emitidos exitosamente')
    ->withInput();
  }

  private function generateMigrationTerceros()
  {

  }

  private function generateMigrationTercerosDirecciones()
  {

  }

  private function generateMigrationPedidos()
  {

  }

}
