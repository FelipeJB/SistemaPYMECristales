<?php

namespace App\Http\Controllers\Informes;

use App\User;
use App\Orden;
use App\Garantia;
use App\PuntoVenta;
use App\Instalador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDF;
use DB;

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
      $puntoOrdenes= array();
      $i = 0;
      $totalmes = 0;
      $totalmesU = 0;
      foreach($puntosVenta as $puntoVenta){
        $ordenes = Orden::whereMonth('ordFecha', '=', $mes)->whereYear('ordFecha', '=', $anio)->where('ordPuntoVentaID', '=', $puntoVenta->pvID)->get();
        if(count($ordenes) > 0){
          $puntoOrdenes[$i]['totalPuntoVenta'] = 0;
          $puntoOrdenes[$i]['totalPuntoVentaC'] = 0;
          $puntoOrdenes[$i]['totalPuntoVentaU'] = 0;
          $puntoOrdenes[$i]['puntoVenta'] = $puntoVenta->pvNombre;
          $puntoOrdenes[$i]['ordenes'] = array();
          $k = 0;
          foreach($ordenes as $orden){
            $puntoOrdenes[$i]['ordenes'][$k] = $orden;
            $orden->ordTotalUtilidades = $orden->ordTotal - $orden->ordTotalCompra;
            $puntoOrdenes[$i]['totalPuntoVenta'] += $orden->ordTotal;
            $puntoOrdenes[$i]['totalPuntoVentaC'] += $orden->ordTotalCompra;
            $puntoOrdenes[$i]['totalPuntoVentaU'] += $orden->ordTotalUtilidades;
            $totalmes += $orden->ordTotal;
            $totalmesU += $orden->ordTotalUtilidades;
            $k++;
          }
          $i++;
        }
      }
      if (count($puntoOrdenes)>0){
        return $this->generateInformVentas($puntoOrdenes, $mes, $anio, $totalmes, $totalmesU);
      }else{
        return Redirect::back()->with('error', 'No se encontraron ventas para el año y mes especificados')
        ->withInput();
      }
      break;
    case 'garantias':
      $garantias = Garantia::whereMonth('grnFecha', '=', $mes)->whereYear('grnFecha', '=', $anio)->get();
      $instaladores = Instalador::where('insActivo', '=', 1)->get();
      //$instaladorGarantias[] = array('insNombre', 'insApellido', 'ordenes', 'totalMes', 'totalInstalador');
      $instaladorGarantias = array();
      $i = 0;
      $totalMes = 0;
      foreach($instaladores as $instalador){
        $ordenes = DB::table('garantias')
        ->join('ordens', 'ordens.ordID', '=', 'garantias.grnOrdenID')
        ->whereMonth('grnFecha', '=', $mes)
        ->whereYear('grnFecha', '=', $anio)
        ->where('ordInstaladorID', '=', $instalador->insID)->get();

        if(count($ordenes) > 0){
          $instaladorGarantias[$i]['insNombre'] = $instalador->insNombre;
          $instaladorGarantias[$i]['insApellido'] = $instalador->insApellido;
          $instaladorGarantias[$i]['totalInstalador'] = 0;
          $instaladorGarantias[$i]['ordenes'] = array();
          $k = 0;
          foreach($ordenes as $orden){
            $garantia = Garantia::where('grnOrdenID', '=', $orden->ordID)->first();
            $orden->grnFecha = $garantia->grnFecha;
            $orden->grnObservaciones = $garantia->grnObservaciones;
            $instaladorGarantias[$i]['ordenes'][$k] = $orden;
            $instaladorGarantias[$i]['totalInstalador'] += 1;
            $totalMes += 1;
            $k++;
          }
          $i++;
        }
      }
      if (count($instaladorGarantias)>0){
        return $this->generateInformGarantias($instaladorGarantias, $mes, $anio, $totalMes);
      }else{
        return Redirect::back()->with('error', 'No se encontraron garantías registradas para el año y mes especificados')
        ->withInput();
      }
      break;
    case 'instalaciones':
      $instaladores = Instalador::where('insActivo', '=', 1)->get();
      $instaladorOrdenes = array();
      $i = 0;
      $totalMesSI = 0;
      $totalMesNO = 0;
      foreach($instaladores as $instalador){
        $ordenes = Orden::whereMonth('ordFechaInstalacion', '=', $mes)->whereYear('ordFechaInstalacion', '=', $anio)->where('ordInstaladorID', '=', $instalador->insID)->get();
        if(count($ordenes) > 0){
          $instaladorOrdenes[$i]['insNombre'] = $instalador->insNombre;
          $instaladorOrdenes[$i]['insApellido'] = $instalador->insApellido;
          $instaladorOrdenes[$i]['totalInstaladorSI'] = 0;
          $instaladorOrdenes[$i]['totalInstaladorNO'] = 0;
          $instaladorOrdenes[$i]['ordenes'] = array();
          $k = 0;
          foreach($ordenes as $orden){
            $instaladorOrdenes[$i]['ordenes'][$k] = $orden;
            if($orden->ordEstadoInstalacionID == 4){
              $totalMesSI += 1;
              $instaladorOrdenes[$i]['totalInstaladorSI'] += 1;
            }else{
              $totalMesNO += 1;
              $instaladorOrdenes[$i]['totalInstaladorNO'] += 1;
            }
            $k++;
          }
          $i++;
        }
      }
      $ordenesNO = Orden::whereMonth('ordFechaInstalacion', '=', $mes)->whereYear('ordFechaInstalacion', '=', $anio)->where('ordEstadoInstalacionID', '=', 3)->get();
      if (count($instaladorOrdenes)>0 || count($ordenesNO)>0){
        return $this->generateInformInstalaciones($instaladorOrdenes, $mes, $anio, $totalMesSI, $totalMesNO, $ordenesNO);
      }else{
        return Redirect::back()->with('error', 'No se encontraron instalaciones programadas para el año y mes especificados')
        ->withInput();
      }
      break;
    }

    //return Redirect::back()->with('success', 'Informe emitido exitosamente')
    //->withInput();
  }

  public function generateInformVentas($puntoOrdenes, $mes, $anio, $totalmes, $totalmesU)
  {
    //Aquí se genera el informe de ventas para el año y mes especificado. En la variable ordenes se encuentran las órdenes de dichas fechas.
    $pdf = PDF::loadView('informes/informeVentasPdf', [
      'puntoOrdenes' => $puntoOrdenes,
      'mes' => $mes,
      'anio' => $anio,
      'totalmes' => $totalmes,
      'totalmesU' => $totalmesU
    ]);
    return $pdf->download('Informe de Ventas '.$mes.'/'.$anio.'.pdf');
  }

  public function generateInformGarantias($instaladorGarantias, $mes, $anio, $totalMes)
  {
    //Aquí se genera el informe de garantias para el año y mes especificado. En la variable garantias se encuentran las garantias registradas en dichas fechas
    $pdf = PDF::loadView('informes/informeGarantiasPdf', [
      'instaladorGarantias' => $instaladorGarantias,
      'mes' => $mes,
      'anio' => $anio,
      'totalMes' => $totalMes
    ]);
    return $pdf->download('Informe de Garantías '.$mes.'/'.$anio.'.pdf');
}

  public function generateInformInstalaciones($instaladorOrdenes, $mes, $anio, $totalMesSi, $totalMesNo, $ordenesNO)
  {
    //Aquí se genera el informe de instalaciones para el año y mes especificado. En la variable ordenes se encuentran las Ordenes instaladas en dichas fechas
    $pdf = PDF::loadView('informes/informeInstalacionesPdf', [
      'instaladorOrdenes' => $instaladorOrdenes,
      'mes' => $mes,
      'anio' => $anio,
      'totalMesSi' => $totalMesSi,
      'totalMesNo' => $totalMesNo,
      'ordenesNO' => $ordenesNO
    ]);
    return $pdf->download('Informe de Instalaciones '.$mes.'/'.$anio.'.pdf');
  }

}
