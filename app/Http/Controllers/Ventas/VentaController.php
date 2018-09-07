<?php

namespace App\Http\Controllers\Ventas;

use Auth;
use App\Cliente;
use App\Orden;
use App\OrdenDetalle;
use App\Sistema;
use App\Color;
use App\PrecioVidrio;
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
        return Redirect::to('/CrearDetalle');
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

  public function createDetail()
  {
    /*Se guardan los datos de la orden detalle de variables desde el formulario*/
    $sistema = Input::get('sistema');
    $milimetraje = Input::get('milimetraje');
    $color = Input::get('color');
    $diseno = Input::get('diseno');
    $vidrios = Input::get('vidrios');
    $toalleros = Input::get('toalleros');
    $adicional = Input::get('adicional');
    $motivo = Input::get('motivo');
    $observaciones = Input::get('observaciones');
    $relacion = Input::get('relacion');
    $alto = Input::get('alto');
    $ancho = Input::get('ancho');
    $descuento = Input::get('descuento');

    //validar que se ingresen tods los datos
    if($vidrios == "" || $toalleros == "" || $ancho == "" || $alto == ""){
      return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
      ->withInput();
    }

    //validar vidrios numéricos
    if(!is_numeric($vidrios)){
      return Redirect::back()->with('vidrios', 'Ingrese una cantidad válida')
      ->withInput();
    }

    //validar toalleros numéricos
    if(!is_numeric($toalleros)){
      return Redirect::back()->with('toalleros', 'Ingrese una cantidad válida')
      ->withInput();
    }

    //validar ancho numérico
    if(!is_numeric($ancho)){
      return Redirect::back()->with('ancho', 'Ingrese un ancho válido')
      ->withInput();
    }

    //validar alto numérico
    if(!is_numeric($alto)){
      return Redirect::back()->with('alto', 'Ingrese un alto válido')
      ->withInput();
    }

    //validar valor adicional numérico
    if(!is_numeric($adicional)){
      return Redirect::back()->with('adicional', 'Ingrese un valor válido')
      ->withInput();
    }

    //crear orden detalle
    $newDetalle = new OrdenDetalle();
    $newDetalle->orddItem = count(Request::session()->get('detalles'))+1;
    $newDetalle->orddDescuento = $descuento;
    $newDetalle->orddCantVidrio = $vidrios;
    $newDetalle->orddCantToalleros = $toalleros;
    $newDetalle->orddSistemaID = $sistema;
    $newDetalle->orddMilimID = $milimetraje;
    $newDetalle->orddColorID = $color;
    $newDetalle->orddDisenoID = $diseno;
    $newDetalle->orddEstadoMedidasID = 1;
    $newDetalle->orddAuxiliarID = Auth::user()->id;
    $newDetalle->orddObservaciones = $observaciones;
    $newDetalle->orddAlto = $alto;
    $newDetalle->orddAncho = $ancho;
    $newDetalle->orddRelacion = $relacion;
    $newDetalle->orddValorAdicional = $adicional;
    $newDetalle->orddDescripcionAdicional = $motivo;

    //Cálculo del precio total de venta
    $sistema = Sistema::where('stmID','=',$sistema)->first();
    $color =  Color::where('clrID','=',$color)->first();
    $precio = PrecioVidrio::where('pvdMilimID','=',$milimetraje)->where('pvdSistemaID','=',$sistema)->first();
    $precioVidrio = ($ancho*$alto*$precio->pvdPrecioVenta*(100-$descuento))/100000000;
    $newDetalle->orddTotal = $precioVidrio + $sistema->stmPrecioVenta + $color->clrPrecioVenta + $adicional + ($toalleros*50000);

    //Cálculo del precio total de compra
    $precioVidrioCompra = ($ancho*$alto*$precio->precioCompra)/1000000;
    $newDetalle->orddTotalCompra = $precioVidrioCompra + $sistema->stmPrecioCompra + $color->clrPrecioCompra + $adicional + ($toalleros*50000);

    //guardar orden detalle en sesión
    $detalles = Request::session()->get('detalles');
    array_push($detalles, $newDetalle);
    Request::session()->put('detalles', $detalles);

    //Verificar si se desea seguir agregando o finalizar
    switch (Request::input('action')) {
    case 'continue':
            return Redirect::to('/CrearDetalle');

        break;
    case 'finish':
            return Redirect::to('/Confirmar');
        break;
    }

  }

}
