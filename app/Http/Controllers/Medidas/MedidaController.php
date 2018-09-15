<?php

namespace App\Http\Controllers\Medidas;

use App\User;
use App\Orden;
use App\OrdenDetalle;
use App\MedidaVidrio;
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
          return Redirect::to('/RegistrarMedidasForm/'.$numero.'/1');
        }
      }

  }

  public function register()
  {


  }

}
