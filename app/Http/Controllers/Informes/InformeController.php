<?php

namespace App\Http\Controllers\Informes;

use App\User;
use App\Orden;
use App\Garantia;
use App\PuntoVenta;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDF;

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
      $puntosVenta = PuntoVenta::where('pvActivo', '=', 1)->get();
      //var_dump($puntosVenta);
      $puntoOrdenes[] = array('puntoVenta', 'ordenes', 'totalPuntoVenta');
      $i = 0;
      foreach($puntosVenta as $puntoVenta){
        $ordenes = Orden::whereMonth('ordFecha', '=', $mes)->whereYear('ordFecha', '=', $anio)->where('ordPuntoVentaID', '=', $puntoVenta->pvID)->get();
        //$ordenes = json_encode(json_decode($ordenes));
        //var_dump(json_encode(json_decode($ordenes)));
        if(count(json_encode(json_decode($ordenes))) > 0){

          $puntoOrdenes[$i]['totalPuntoVenta'] = 0;
          $puntoOrdenes[$i]['puntoVenta'] = $puntoVenta->pvNombre;
          $puntoOrdenes[$i]['ordenes'] = array();
          //var_dump($puntoOrdenes);
          $k = 0;
          foreach($ordenes as $orden){
            //var_dump('entroo');die('muere');
            $puntoOrdenes[$i]['ordenes'][$k] = $orden;
            //$puntoOrdenes[$i][$k] = array();
            //$puntoOrdenes[$i][$k] = $ordenes[$j];
            //var_dump('pasa');die('muere');
            $orden->ordTotalUtilidades = $orden->ordTotal - $orden->ordTotalCompra;
            $puntoOrdenes[$i]['totalPuntoVenta'] += $orden->ordTotal;
            $k++;
          }
          $i++;
        }
      }

      if (count($puntoOrdenes)>0){
        //var_dump('entro');die('muere');
        return $this->generateInformVentas($puntoOrdenes, $mes, $anio);
      }else{
        return Redirect::back()->with('error', 'No se encontraron ventas para el año y mes especificados')
        ->withInput();
      }
      break;
    case 'garantias':
      $garantias = Garantia::whereMonth('grnFecha', '=', $mes)->whereYear('grnFecha', '=', $anio)->get();
      if (count($garantias)>0){
        $this->generateInformGarantias($garantias, $mes, $anio);
      }else{
        return Redirect::back()->with('error', 'No se encontraron garantías registradas para el año y mes especificados')
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

    //return Redirect::back()->with('success', 'Informe emitido exitosamente')
    //->withInput();
  }

  public function generateInformVentas($puntoOrdenes, $mes, $anio)
  {
    //Aquí se genera el informe de ventas para el año y mes especificado. En la variable ordenes se encuentran las órdenes de dichas fechas.
    //Generar planos
    $pdf = PDF::loadView('informes/informeVentasPdf', [
      'puntoOrdenes' => $puntoOrdenes,
      'mes' => $mes,
      'anio' => $anio
    ]);
    return $pdf->download('Informe de Ventas '.$mes.'/'.$anio.'.pdf');
  }

  private function generateInformGarantias($garantias, $mes, $anio)
  {
    //Aquí se genera el informe de garantias para el año y mes especificado. En la variable garantias se encuentran las garantias registradas en dichas fechas
  }

  private function generateInformInstalaciones($ordenes, $mes, $anio)
  {
    //Aquí se genera el informe de instalaciones para el año y mes especificado. En la variable ordenes se encuentran las Ordenes instaladas en dichas fechas
  }

}
