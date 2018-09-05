<?php

namespace App\Http\Controllers\Ventas;

use Auth;
use App\Cliente;
use App\Orden;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class VentaController extends Controller
{

  public function validateClient()
  {
      /*Se guardan los datos del cliente dentro de variables desde el formulario*/
      $numero = Input::get('numero');

      //validar que se ingresen tods los datos
      if($numero == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar número numérico
      if(!is_numeric($numero)){
        return Redirect::back()->with('numero', 'Ingrese un número de documento válido')
        ->withInput();
      }

      //validar cliente registrado y redirigir al siguiente formulario guardando el cliente en la sesión
      $cliente = Cliente::where("cltCedula", "=", $numero)->first();
      if ($cliente==null){
        return Redirect::back()->with('numero', 'No se encontró el cliente en los registros')
        ->withInput();
      }else{
        Request::session()->put('cliente', $cliente);
        return Redirect::to('/CrearOrden');
      }

  }

  public function createOrder()
  {
    /*Se guardan los datos de la orden dentro de variables desde el formulario*/
    $punto = Input::get('punto');
    $formaPago = Input::get('formaPago');

    //crear orden
    $newOrden = new Orden();
    $newOrden->ordPuntoVentaID = $punto;
    $newOrden->ordVendedorID = Auth::user()->id;
    $newOrden->ordFormaPagoID = $formaPago;
    $newOrden->ordEstadoInstalacionID = 0;
    $newOrden->ordMigrado = 0;

    //guardar orden en sesión
    Request::session()->put('orden', $newOrden);

    //redirigir al siguiente formulario
    return Redirect::to('/CrearDetalle');

  }

}
