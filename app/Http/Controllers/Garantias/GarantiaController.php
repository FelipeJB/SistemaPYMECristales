<?php

namespace App\Http\Controllers\Garantias;

use App\User;
use App\Orden;
use App\Garantia;
use App\Cliente;
use App\Instalador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDF;

class GarantiaController extends Controller
{

  public function validateOrderNumber()
  {
      /*Se guardan los datos de la garantia dentro de variables desde el formulario*/
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
        if ($orden->ordEstadoInstalacionID < 4){
          return Redirect::back()->with('numero', 'Esta orden hasta el momento no se encuentra instalada')
          ->withInput();
        }else{
          return Redirect::to('/RegistrarGarantiaForm/'.$numero);
        }
      }

  }

  public function validateOrderNumberInforme()
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

      //validar orden registrada con garantía y redirigir al siguiente formulario guardando el número de orden en la sesión
      $orden = Orden::where("ordID", "=", $numero)->first();
      if ($orden == null){
        return Redirect::back()->with('numero', 'No se encontró el número de orden en los registros')
        ->withInput();
      }else{
        $garantia = Garantia::where("grnOrdenID", "=", $numero)->first();
        if ($garantia == null){
          return Redirect::back()->with('numero', 'No se encontró garantía para la orden especificada')
          ->withInput();
        }else{
          return Redirect::to('/ConsultarGarantia/'.$numero);
        }
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
      date_default_timezone_set('America/Bogota');
      $newGarantia = new Garantia();
      $newGarantia->grnFecha = date("Y-m-d");
      $newGarantia->grnOrdenID = $ordID;
      $newGarantia->grnObservaciones = $observaciones;
      $newGarantia->save();

      $this->generateWarrantyOrder($ordID);

      return Redirect::to('/')->with('success', 'La garantía ha sido registrada exitosamente')->withInput();

    }catch(\Exception $exception){
      return Redirect::back()->with('error', 'La garantía no pudo ser registrada')->withInput();
    }

  }

  public function getWarrantyDocument($id)
  {
    //$this->generateWarrantyOrder($id);
    //return Redirect::to('/')->with('success', 'Documento generado exitosamente')->withInput();

    //Obtener la garantía especificada
    $garantia = Garantia::where("grnOrdenID", "=", $id)->first();

    //Obtener datos para el documento
    $orden = \App\Orden::where('ordID','=',$id)->first();
    $cliente = \App\Cliente::where('cltID','=',$orden->ordClienteID)->first();
    $instalador = \App\Instalador::where('insID','=',$orden->ordInstaladorID)->first();
    $vendedor = \App\User::where('id','=',$orden->ordVendedorID)->first();

    //Generar informe de garantia
    $pdf = PDF::loadView('garantias/generarGarantiaPdf', [
      'garantia' => $garantia,
      'orden' => $orden,
      'cliente' => $cliente,
      'instalador' => $instalador,
      'vendedor' => $vendedor
    ]);
    return $pdf->download('Garantia de Orden N'.$id.'.pdf');
  }

  private function generateWarrantyOrder($id)
  {
    $this->getWarrantyDocument($id);
  }

}
