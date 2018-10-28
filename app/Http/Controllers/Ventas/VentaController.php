<?php

namespace App\Http\Controllers\Ventas;

use Auth;
use App\Cliente;
use App\Orden;
use App\OrdenDetalle;
use App\Sistema;
use App\Color;
use App\PrecioVidrio;
use App\PuntoVenta;
use App\User;
use App\FormaPago;
use App\Garantia;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDF;

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
    $abono = Input::get('abono');
    $observaciones = Input::get('observaciones');

    // Se calcula el precio total de compra y de venta
    $total = $totalCompra = 0;
    $detalles = Request::session()->get('detalles');
    foreach($detalles as $d){
      $total = $total + $d->orddTotal;
      $totalCompra = $totalCompra + $d->orddTotalCompra;
    }

    //validar abono numérico
    if(!is_numeric($abono) || $abono < 0 || $abono > $totalCompra){
      return Redirect::back()->with('abono', 'Ingrese un abono válido')
      ->withInput();
    }

    //guardar Cliente si no está registrado
    $cliente = Request::session()->get('cliente');
    if($cliente->cltID == null){
      $cliente->save();
    }

    //crear orden
    $newOrden = new Orden();
    $newOrden->ordNumeroPedido = 0;
    $newOrden->ordClienteID = $cliente->cltID;
    $newOrden->ordPuntoVentaID = $punto;
    $newOrden->ordTotal = $total;
    $newOrden->ordTotalCompra = $totalCompra;
    $newOrden->ordSaldo = $total - $abono;
    $newOrden->ordAbono = $abono;
    $newOrden->ordObservaciones = $observaciones;
    $newOrden->ordVendedorID = Auth::user()->id;
    $newOrden->ordFormaPagoID = $formaPago;
    $newOrden->ordEstadoInstalacionID = 1;
    date_default_timezone_set('America/Bogota');
    $newOrden->ordFecha = date("Y-m-d");
    $newOrden->ordMigrado = 0;
    $newOrden->save();
    $newOrden->ordNumeroPedido = $newOrden->ordID;
    $newOrden->save();

    //crear Detalles
    foreach($detalles as $d){
      $d->orddOrdenID=$newOrden->ordID;
      $d->save();
    }

    //Ingresar valores vacíos a los datos de sesión
    Request::session()->put('detalles', null);
    Request::session()->put('cliente', null);

    //redirigir a la página siguiente
    return Redirect::to('/FinalizarVenta/'.$newOrden->ordID);

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
    $precioVidrioCompra = ($ancho*$alto*$precio->pvdPrecioCompra)/1000000;
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

  public function createOrderDocument($id)
  {
    //Obtener datos para el documento
    $orden = \App\Orden::where('ordID','=',$id)->first();
    $detalles = \App\OrdenDetalle::where('orddOrdenID','=',$id)->get();
    $cliente = \App\Cliente::where('cltID','=',$orden->ordClienteID)->first();
    $puntoVenta = \App\PuntoVenta::where('pvID','=',$orden->ordPuntoVentaID)->first();
    $vendedor = \App\User::where('id','=',$orden->ordVendedorID)->first();
    $formaPago = \App\FormaPago::where('fpID','=',$orden->ordFormaPagoID)->first();

    $sistemas = array();
    $milimetrajes = array();
    $colores = array();
    $disenos = array();
    $observaciones = array();
    $i = 0;

    foreach ($detalles as $detalle) {
      $sistemas[$i] = \App\Sistema::where('stmID','=',$detalle->orddSistemaID)->first();
      $milimetrajes[$i] = \App\Milimetraje::where('mlmID','=',$detalle->orddMilimID)->first();
      $colores[$i] = \App\Color::where('clrID','=',$detalle->orddColorID)->first();
      $disenos[$i] = \App\Diseno::where('dsnID','=',$detalle->orddDisenoID)->first();
      if($detalle->orddObservaciones != null){
        $observaciones[$i] = ' Item '.$detalle->orddItem.': '.$detalle->orddObservaciones;
      }
      $i++;
    }

    //Generar informe de venta
    $pdf = PDF::download('ventas/generarInformePdf', [
      'orden' => $orden,
      'detalles' => $detalles,
      'cliente' => $cliente,
      'puntoVenta' => $puntoVenta,
      'vendedor' => $vendedor,
      'formaPago' => $formaPago,
      'sistemas' => $sistemas,
      'milimetrajes' => $milimetrajes,
      'colores' => $colores,
      'disenos' => $disenos,
      'observaciones' => $observaciones
    ]);
    return $pdf->download('Orden de Pedido N'.$id.'.xlsx');

  }

  public function validateOrderNumberConsulta()
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
        return Redirect::to('/ConsultarVenta/'.$numero);
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

      //validar orden registrada y redirigir al siguiente formulario guardando el número de orden en la sesión
      $orden = Orden::where("ordID", "=", $numero)->first();
      if ($orden == null){
        return Redirect::back()->with('numero', 'No se encontró el número de orden en los registros')
        ->withInput();
      }else{
        return Redirect::to('/GenerarInformeVenta/'.$numero);
      }

  }

  public function validateInstalationOrderNumber()
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

      //validar orden registrada con medidas y redirigir al siguiente formulario
      $orden = Orden::where("ordID", "=", $numero)->first();
      if ($orden == null){
        return Redirect::back()->with('numero', 'No se encontró el número de orden en los registros')
        ->withInput();
      }else{
        if ($orden->ordEstadoInstalacionID == 1){
          return Redirect::back()->with('numero', 'No se han tomado medidas para la orden especificada')
          ->withInput();
        }else{
          $garantia = Garantia::where("grnOrdenID","=",$orden->ordID)->first();
          if ($garantia != null){
            return Redirect::back()->with('numero', 'Esta orden contiene garantía, por lo cual ya se encuentra instalada')
            ->withInput();
          }else{
            return Redirect::to('/ProgramarInstalacionForm/'.$numero);
          }
        }
      }

  }

  public function registerInstalation()
  {
    /*Se guardan los datos de la instalación dentro de variables desde el formulario*/
    $fecha = Input::get('fecha');
    $instalador = Input::get('instalador');
    $ordID = Input::get('ordID');
    $orden = Orden::where("ordID", "=", $ordID)->first();
    $motivo = Input::get('motivo');

    switch (Request::input('action')) {
    case 'registrarProgramacion':
      //caso en que se registra la programación

      //validar que se ingresen todos los datos
      if($fecha == ""){
        return Redirect::back()->with('error', 'Se debe ingresar una fecha')
        ->withInput();
      }

      if($fecha < $orden->ordFecha){
        return Redirect::back()->with('error', 'La fecha ingresada no es válida')
        ->withInput();
      }

      try{
        //Actualización de los datos de la orden
        $orden->ordFechaInstalacion = $fecha;
        $orden->ordEstadoInstalacionID = 4;
        $orden->ordInstaladorID = $instalador;
        $orden->ordRazonNegativa = null;
        $orden->save();

        return Redirect::to('/')->with('success', 'La instalación se ha programado exitosamente para la fecha '.substr($fecha,0, -6))->withInput();

      }catch(\Exception $exception){
        return Redirect::back()->with('error', 'La instalación no pudo ser programada')->withInput();
      }

      break;
    case 'noRegistrarProgramacion':
      //Caso en el cual no se pudo registrar la programación

      //validar que se ingresen tods los datos
      if($motivo == ""){
        return Redirect::back()->with('error', 'Si la instalación no pudo ser programada se debe ingresar un motivo')
        ->withInput();
      }

      //Verificar estado de Medidas
      $orden->ordEstadoInstalacionID = 3;
      $detalles = OrdenDetalle::where("orddOrdenID","=",$orden->ordID)->get();
      foreach($detalles as $d){
        if($d->orddEstadoMedidasID == 1){
          $orden->ordEstadoInstalacionID = 2;
        }
      }

      //Modificar orden
      date_default_timezone_set('America/Bogota');
      $orden->ordFechaInstalacion = date("Y-m-d");
      $orden->ordInstaladorID = null;
      $orden->ordRazonNegativa = $motivo;
      $orden->save();

      return Redirect::to('/')->with('success', 'Se guardó el motivo de la no programación de la instalación')->withInput();
      break;
    }
  }

  private function roundUpToAny($n,$x=5) {
    return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
  }

}
