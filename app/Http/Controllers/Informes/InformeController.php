<?php

namespace App\Http\Controllers\Informes;

use App\User;
use App\Orden;
use App\OrdenDetalle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class InformeController extends Controller
{

  public function create()
  {
    /*Se guardan los datos del informe dentro de variables desde el formulario*/
    $anio = Input::get('anio');
    $mes = Input::get('mes');
    $tipo = Input::get('tipo');

    //validar que se ingresen tods los datos
    if($mes == ""){
      return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
      ->withInput();
    }

    //validar año numérico
    if(!is_numeric($anio)){
      return Redirect::back()->with('anio', 'Ingrese un año válido')
      ->withInput();
    }

    //verificar existencia y llamar función de generación
    switch ($tipo) {
    case 'ventas':
      $ordenes = Orden::whereMonth('ordFecha', '=', $mes)->whereYear('ordFecha', '=', $anio)->get();
      if (count($ordenes)>0){
        $this->generateInformVentas($ordenes, $mes, $anio);
      }else{
        return Redirect::back()->with('error', 'No se encontraron ventas para el año y mes especificados')
        ->withInput();
      }
      break;
    case 'medidas':
      $detalles = OrdenDetalle::whereMonth('orddFechaMedidas', '=', $mes)->whereYear('orddFechaMedidas', '=', $anio)->get();
      if (count($detalles)>0){
        $this->generateInformMedidas($detalles, $mes, $anio);
      }else{
        return Redirect::back()->with('error', 'No se encontraron medidas tomadas para el año y mes especificados')
        ->withInput();
      }
      break;
    case 'instalaciones':
      $ordenes = Orden::whereMonth('ordFechaInstalacion', '=', $mes)->whereYear('ordFechaInstalacion', '=', $anio)->get();
      if (count($ordenes)>0){
        $this->generateInformInstalaciones($ordenes, $mes, $anio);
      }else{
        return Redirect::back()->with('error', 'No se encontraron instalaciones programadas para el año y mes especificados')
        ->withInput();
      }
      break;
    }

    return Redirect::back()->with('success', 'Informe emitido exitosamente')
    ->withInput();
  }

  private function generateInformVentas($ordenes, $mes, $anio)
  {
    //Aquí se genera el informe de ventas para el año y mes especificado. En la variable ordenes se encuentran las órdenes de dichas fechas.
  }

  private function generateInformMedidas($detalles, $mes, $anio)
  {
    //Aquí se genera el informe de medidas para el año y mes especificado. En la variable detalles se encuentran las OrdenDetalle medidas en dichas fechas
  }

  private function generateInformInstalaciones($ordenes, $mes, $anio)
  {
    //Aquí se genera el informe de instalaciones para el año y mes especificado. En la variable ordenes se encuentran las Ordenes instaladas en dichas fechas
  }

}
