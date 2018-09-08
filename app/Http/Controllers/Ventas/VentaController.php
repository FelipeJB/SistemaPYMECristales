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
    if(!is_numeric($adicional) && $adicional!=""){
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
    $newDetalle->orddAuxiliarID = 0;
    $newDetalle->orddObservaciones = $observaciones;
    $newDetalle->orddAlto = $alto;
    $newDetalle->orddAncho = $ancho;
    $newDetalle->orddRelacion = $relacion;
    $newDetalle->orddValorAdicional = $adicional;
    $newDetalle->orddDescripcionAdicional = $motivo;

    //Cálculo del precio total de venta
    $stm = Sistema::where('stmID','=',$sistema)->first();
    $clr =  Color::where('clrID','=',$color)->first();
    $precio = PrecioVidrio::where('pvdMilimID','=',$milimetraje)->where('pvdSistemaID','=',$sistema)->first();
    $precioVidrio = ($ancho*$alto*$precio->pvdPrecioVenta*(100-$descuento))/100000000;
    $newDetalle->orddTotal = $this->roundUpToAny(($precioVidrio + $stm->stmPrecioVenta + $clr->clrPrecioVenta + $adicional + ($toalleros*50000)),50);

    //Cálculo del precio total de compra
    $precioVidrioCompra = ($ancho*$alto*$precio->precioCompra)/1000000;
    $newDetalle->orddTotalCompra = $this->roundUpToAny(($precioVidrioCompra + $stm->stmPrecioCompra + $clr->clrPrecioCompra + $adicional + ($toalleros*50000)),50);

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
            return Redirect::to('/ConfirmarDetalles');
        break;
    }

  }

  public function deleteDetail($id) {
    if(Request::session()->has('cliente') && Request::session()->has('detalles') && Auth::user()->usrRolID==2){
      if(count(Request::session()->get('detalles'))>=$id){
        $detalles = Request::session()->get('detalles');
        array_splice($detalles, $id-1,1);
        for($i=$id-1;$i<count($detalles);$i++){
          $detalles[$i]->orddItem--;
        }
        Request::session()->put('detalles', $detalles);
        return Redirect::back()->with('success', 'El detalle se eliminó exitosamente');
      }
    }
    return Redirect::to('/');
  }

  public function cancelOrder() {
    if(Request::session()->has('cliente') && Request::session()->has('detalles') && Auth::user()->usrRolID==2){
      Request::session()->put('detalles', null);
      Request::session()->put('cliente', null);
    }
    return Redirect::to('/');
  }

  private function roundUpToAny($n,$x=5) {
    return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
  }

}
