<?php

namespace App\Http\Controllers\Medidas;

use Auth;
use App\User;
use App\Sistema;
use App\Orden;
use App\OrdenDetalle;
use App\MedidaVidrio;
use App\DatosMedida;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MedidaController extends Controller
{

  public function validateOrderNumber()
  {
      /*Se guardan los datos de la orden dentro de variables desde el formulario*/
      $numero = Input::get('numero');

      //validar que se ingresen tods los datos
      if($numero == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar número numérico
      if(!is_numeric($numero)){
        return Redirect::back()->with('numero', 'Ingrese un número de orden válido')
        ->withInput();
      }

      //validar orden registrada y redirigir al siguiente formulario guardando el número de orden en la sesión
      $orden = Orden::where("ordID", "=", $numero)->first();
      if ($orden == null){
        return Redirect::back()->with('numero', 'No se encontró el número de orden en los registros')
        ->withInput();
      }else{
        $detalles = OrdenDetalle::where("orddOrdenID", "=", $numero)->get();
        $medidas = 0;
        foreach ($detalles as $d){
          $medida = MedidaVidrio::where("mvdOrddID", "=", $d->orddID)->first();
          if ($medida != null){
            $medidas++;
          }
        }
        if ($medidas == count($detalles)){
          return Redirect::back()->with('numero', 'La orden ingresada ya tiene todas sus medidas registradas')
          ->withInput();
        }else{
          Request::session()->put('medidas', []);
          Request::session()->put('orden', $orden->ordID);
          return Redirect::to('/RegistrarMedidasForm/'.$numero.'/1');
        }
      }

  }

  public function register()
  {
    /*Se guardan los datos dentro de variables desde el formulario*/
    $idOrden = Input::get('ordID');
    $idDetalle = Input::get('orddID');
    $item = Input::get('item');
    $ladoPuerta = Input::get('lado');
    $alto = Input::get('alto');
    $ancho1 = Input::get('ancho1');
    $ancho2 = Input::get('ancho2');
    $anchoPuerta = Input::get('anchoPuerta');
    $observaciones = Input::get('observaciones');
    $motivo = Input::get('motivo');
    $medida = new DatosMedida();
    $detalle = OrdenDetalle::where("orddID", "=", $idDetalle)->first();
    $sistema = Sistema::where("stmID", "=", $detalle->orddSistemaID)->first();

    switch (Request::input('action')) {
    case 'registrarMedidas':
            //Caso en el cual se pudo tomar las medidas

            //validar que se ingresen todos los datos
            if($alto == "" || $ancho1 == "" || $ancho2 == ""){
              return Redirect::back()->with('error', 'Se deben ingresar todos los datos marcados con un (*)')
              ->withInput();
            }

            //validar que se ingrese el anchoPuerta si es batiente y que sea numérico
            if ($sistema->stmTipo == "Batiente"){
              if($anchoPuerta == ""){
                return Redirect::back()->with('error', 'Se deben ingresar todos los datos marcados con un (*)')
                ->withInput();
              }
              else if(!is_numeric($anchoPuerta)){
                return Redirect::back()->with('error', 'Las medidas deben ser numéricas')
                ->withInput();
              }
            }

            //validar que las medidas sean numéricas
            if(!is_numeric($ancho1)){
              return Redirect::back()->with('error', 'Las medidas deben ser numéricas')
              ->withInput();
            }
            if(!is_numeric($ancho2)){
              return Redirect::back()->with('error', 'Las medidas deben ser numéricas')
              ->withInput();
            }
            if(!is_numeric($alto)){
              return Redirect::back()->with('error', 'Las medidas deben ser numéricas')
              ->withInput();
            }

            //Ingresar datos en datosmedida
            $medida->esPositiva = true;
            $medida->alto = $alto;
            $medida->ancho1 = $ancho1;
            $medida->ancho2 = $ancho2;
            $medida->ladoPuerta = $ladoPuerta;
            $medida->observaciones = $observaciones;
            $medida->idDetalle = $idDetalle;
            if ($sistema->stmTipo == "Batiente"){
              $medida->esBatiente = true;
              $medida->anchoPuerta = $anchoPuerta;
            }else {
              $medida->esBatiente = false;
            }
            if ($detalle->orddRelacion !=0){
              $medida->esCompuesto = true;
            }else {
              $medida->esCompuesto = false;
            }

        break;
    case 'noRegistrarMedidas':
           //Caso en el cual no se pudo tomar las medidas

           //validar que se ingresen tods los datos
           if($motivo == ""){
             return Redirect::back()->with('error', 'Si la toma de medidas no pudo ser realizada se debe ingresar un motivo')
             ->withInput();
           }

           //Ingresar datos en datosmedida
           $medida->esPositiva = false;
           $medida->razonNegativa = $motivo;
           $medida->idDetalle = $idDetalle;

        break;
    }

    //guardar la medida en sesión
    if(Request::session()->get('orden') != $idOrden){
      return Redirect::to('/RegistrarMedidas')->with('error', 'Orden no válida');
    }else{
      $medidas = Request::session()->get('medidas');
      //si ya existe la medida se modifica, sino se agrega
      $existe = -1;
      for($i = 0; $i<count($medidas); $i++){
        if($medidas[$i]->idDetalle == $medida->idDetalle){
          $existe = $i;
        }
      }
      if($existe  >= 0){
        $medidas[$existe] = $medida;
        Request::session()->put('medidas', $medidas);
      }else{
        array_push($medidas, $medida);
        Request::session()->put('medidas', $medidas);
      }
    }

    //se redirige a la siguiente medida
    return Redirect::to('/RegistrarMedidasForm/'.$idOrden.'/'.($item+1));

  }

  public function confirm()
  {


  }

  public function cancel()
  {
    if(Request::session()->has('orden') && Request::session()->has('medidas') && Auth::user()->usrRolID==3){
      Request::session()->put('orden', null);
      Request::session()->put('medidas', null);
    }
    return Redirect::to('/');
  }

}
