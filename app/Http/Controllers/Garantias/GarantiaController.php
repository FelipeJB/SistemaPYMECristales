<?php

namespace App\Http\Controllers\Garantias;

use App\User;
use App\Orden;
use App\Garantia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class GarantiaController extends Controller
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
        return Redirect::to('/RegistrarGarantiaForm/'.$numero);
      }

  }

  public function register()
  {
    /*Se guardan los datos de la orden dentro de variables desde el formulario*/
    $observaciones = Input::get('observaciones');
    $ordID = Input::get('ordID');

    //validar que se ingresen todos los datos
    if($observaciones == ""){
      return Redirect::back()->with('error', 'Se debe ingresar una observación')
      ->withInput();
    }

    try{
      //creación del cliente
      $newGarantia = new Garantia();
      $newGarantia->grnFecha = date("Y-m-d");
      $newGarantia->grnOrdenID = $ordID;
      $newGarantia->grnObservaciones = $observaciones;
      $newGarantia->save();

      $this->generateWarrantyOrder();

      return Redirect::to('/')->with('success', 'La garantía ha sido registrada exitosamente')->withInput();

    }catch(\Exception $exception){
      return Redirect::back()->with('error', 'La garantía no pudo ser registrada')->withInput();
    }

  }

  private function generateWarrantyOrder()
  {
    //Aquí se genera el informe de garantía
  }


}
