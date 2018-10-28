<?php

namespace App\Http\Controllers\Migraciones;

use App\Migracion;
use App\Orden;
use App\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Excel;

class MigracionController extends Controller
{

  public function create()
  {
    /*Se guardan los datos de la migración dentro de variables desde el formulario*/
    $tipo = Input::get('tipo');

    //Traer clientes y órdenes
    $clientes= Cliente::where("cltMigrado", "=", $tipo)->get();
    $ordenes= Orden::where("ordMigrado", "=", $tipo)->get();

    //validar que haya cosas que migrar si el tipo es 0
    if($tipo == 0){
      if (count($clientes) == 0 && count($ordenes)  == 0){
        return Redirect::back()->with('error', 'No existen registros nuevos que migrar')
        ->withInput();
      }
    }

    //generar documentos
    $this->generateMigrationTerceros($clientes, $ordenes);
    $this->generateMigrationTercerosDirecciones($clientes, $ordenes);
    $this->generateMigrationPedidos($clientes, $ordenes);

    //crear y asignar la migración a los objetos si es migración de tipo 0
    if($tipo == 0){
      date_default_timezone_set('America/Bogota');
      $migracion = new Migracion();
      $migracion->mgcFecha = date("Y-m-d H:i");
      $migracion->save();
      foreach($ordenes as $o){
        $o->ordMigrado = $migracion->mgcID;
        $o->save();
      }
      foreach($clientes as $c){
        $c->cltMigrado = $migracion->mgcID;
        $c->save();
      }
    }

    return Redirect::back()->with('success', 'Archivos de migración exportados exitosamente')
    ->withInput();
  }

  public function generateMigrationTerceros($clientes, $ordenes)
  {
    $clientes= Cliente::where("cltMigrado", "=", 0)->get();
    //Aquí se genera el excel de terceros con los clientes y órdenes especificados.
    $customer_array[] = array('Nombre', 'Apellido', 'Email');
    foreach ($clientes as $cliente) {
      $customer_array[] = array('Nombre' => $cliente->cltNombre,
                                'Apellido' => $cliente->cltApellido,
                                'Email' => $cliente->cltEmail);
    }
    Excel::create('Customer data', function($excel) use ($customer_array){
      $excel->setTitle('Customer data');
      $excel->sheet('Customer data', function($sheet) use ($customer_array){
        $sheet->fromArray($customer_array, null, 'A1', false, false);
      });
    })->download('xlsx');
  }

  private function generateMigrationTercerosDirecciones($clientes, $ordenes)
  {
    //Aquí se genera el excel de terceros direcciones con los clientes y órdenes especificados.
  }

  private function generateMigrationPedidos($clientes, $ordenes)
  {
    //Aquí se genera el excel de pedidos con los clientes y órdenes especificados.
  }

}
