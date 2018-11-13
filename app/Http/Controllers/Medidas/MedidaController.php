<?php

namespace App\Http\Controllers\Medidas;

use Auth;
use App\User;
use App\Sistema;
use App\Color;
use App\PrecioVidrio;
use App\Orden;
use App\OrdenDetalle;
use App\MedidaVidrio;
use App\Milimetraje;
use App\Diseno;
use App\Cliente;
use App\DatosMedida;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDF;

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

  public function validateOrderNumberPlanos()
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

      //validar orden registrada con medidas y redirigir a la página de generación de planos
      $orden = Orden::where("ordID", "=", $numero)->first();
      if ($orden == null){
        return Redirect::back()->with('numero', 'No se encontró el número de orden en los registros')
        ->withInput();
      }else{
        if ($orden->ordEstadoInstalacionID == 1){
          return Redirect::back()->with('numero', 'No se han tomado medidas para la orden especificada')
          ->withInput();
        }else{
          return Redirect::to('/GenerarPlanosMedidas/'.$numero);
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
              else if($anchoPuerta <=0){
                return Redirect::back()->with('error', 'Todas las medidas deben ser positivas')
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

            //validar que medidas sean mayores a 0
            if((is_numeric($ancho1) && $ancho1 <= 0) || (is_numeric($ancho2) && $ancho2 <= 0) || (is_numeric($alto) && $alto <= 0)){
              return Redirect::back()->with('error', 'Todas las medidas deben ser positivas')
              ->withInput();
            }

            if($detalle->orddRelacion != 0){
              if ($ancho1 != $ancho2){
                return Redirect::back()->with('error', 'Para sistemas compuestos los anchos deben ser iguales')
                ->withInput();
              }
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

  public function edit()
  {
    /*Se guardan los datos dentro de variables desde el formulario*/
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
              else if($anchoPuerta <=0){
                return Redirect::back()->with('error', 'Todas las medidas deben ser positivas')
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

            //validar que medidas sean mayores a 0
            if((is_numeric($ancho1) && $ancho1 <= 0) || (is_numeric($ancho2) && $ancho2 <= 0) || (is_numeric($alto) && $alto <= 0)){
              return Redirect::back()->with('error', 'Todas las medidas deben ser positivas')
              ->withInput();
            }

            if($detalle->orddRelacion != 0){
              if ($ancho1 != $ancho2){
                return Redirect::back()->with('error', 'Para sistemas compuestos los anchos deben ser iguales')
                ->withInput();
              }
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
    case 'cancelar':
           //Caso en el cual se cancela la edición

           //redirigir a confirmación
           return Redirect::to('/ConfirmarMedidas');


        break;
    }

    //guardar la medida en sesión
    $medidas = Request::session()->get('medidas');
    $medidas[$item] = $medida;
    Request::session()->put('medidas', $medidas);

    //se redirige a la página de confirmación
    return Redirect::to('/ConfirmarMedidas')->with('success','Se editaron los datos de la medida satisfactoriamente');

  }

  public function confirm()
  {
    if(Auth::user()->usrRolID == 3){
      if(Request::session()->has('medidas') && Request::session()->has('orden')){
        $numOrden = Request::session()->get('orden');
        $medidas = Request::session()->get('medidas');
        $registros = MedidaVidrio::where("mvdOrdID", "=", $numOrden)->count();
        $total = OrdenDetalle::where("orddOrdenID", "=", $numOrden)->count();
        if((count($medidas) + ($registros/2)) == $total){
            //calcular y guardar Medidas
            $this->calcularMedidas($medidas);

            //Actualizar precios y medidas de ser necesario y si ya se tomaron todas las medidas
            $medidasTomadas = MedidaVidrio::where("mvdOrdID", "=", $numOrden)->count();
            if(($medidasTomadas/2) == $total){
              $orden = Orden::where("ordID", "=", $numOrden)->first();
              $orden->ordEstadoInstalacionID = 3;
              $this->recalcularPrecios($orden);
            }

            //borrar datos de sesión
            Request::session()->put('orden', null);
            Request::session()->put('medidas', null);

            //redirigir a la página siguiente
            return Redirect::to('/FinalizarMedidas/'.$numOrden);

        }else{
            return Redirect::back()->with('error','Se deben registrar todas las medidas');
        }
      } else{
        return Redirect::to('/RegistrarMedidas');
      }
    }else{
      return Redirect::to('/');
    }
  }

  private function calcularMedidas($medidas)
  {
    foreach ($medidas as $m){
      if ($m->esPositiva){
        $detalle = OrdenDetalle::where("orddID", "=", $m->idDetalle)->first();
        $sistema = Sistema::where("stmID", "=", $detalle->orddSistemaID)->first();
        $anchoFDAr = 0;
        $anchoFDAb = 0;
        $desc = false;
        $anchoFFAr = 0;
        $anchoFFAb = 0;
        $altoFD = 0;
        $altoFF = 0;
        $anchoI = max($m->ancho2, $m->ancho1);

        // En el siguiente switch se encuentran las fórmulas para cada sistema en particular. Al agregar un nuevo sistema se debe registrar su cálculo como un caso.
        switch ($sistema->stmDescripcion) {

          case 'BATIENTE NORMAL TRASLAPADA':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr) + 30;
              $anchoFFAb = ($m->ancho1 - $anchoFDAb) + 30;
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr) + 30;
              $anchoFFAb = ($anchoI - $anchoFDAb) + 30;
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE NORMAL CHAFLAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE NORMAL IMAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            $anchoFFAr = $anchoFFAr - 25;
            $anchoFFAb = $anchoFFAb - 25;
            break;

          case 'BATIENTE REDONDA TRASLAPADA':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr) + 30;
              $anchoFFAb = ($m->ancho1 - $anchoFDAb) + 30;
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr) + 30;
              $anchoFFAb = ($anchoI - $anchoFDAb) + 30;
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE REDONDA CHAFLAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE REDONDA IMAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            $anchoFFAr = $anchoFFAr - 25;
            $anchoFFAb = $anchoFFAb - 25;
            break;

          case 'BATIENTE ESQUINAS TRASLAPADA':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr) + 30;
              $anchoFFAb = ($m->ancho1 - $anchoFDAb) + 30;
              $altoFD = $m->alto - 8;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr) + 30;
              $anchoFFAb = ($anchoI - $anchoFDAb) + 30;
              $altoFD = $m->alto - 8;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE ESQUINAS CHAFLAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 8;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 8;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE ESQUINAS IMAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 8;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 8;
              $altoFF = $m->alto;
            }
            $anchoFFAr = $anchoFFAr - 25;
            $anchoFFAb = $anchoFFAb - 25;
            break;

          case 'BATIENTE ARAÑA TRASLAPADA':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr) + 30;
              $anchoFFAb = ($m->ancho1 - $anchoFDAb) + 30;
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr) + 30;
              $anchoFFAb = ($anchoI - $anchoFDAb) + 30;
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE ARAÑA CHAFLAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            break;

          case 'BATIENTE ARAÑA IMAN':
            $anchoFDAr = $m->anchoPuerta;
            $anchoFDAb = $m->anchoPuerta;
            if(abs($m->ancho2 - $m->ancho1) >= 5 ){
              $anchoFFAr = ($m->ancho2 - $anchoFDAr);
              $anchoFFAb = ($m->ancho1 - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI - $anchoFDAr);
              $anchoFFAb = ($anchoI - $anchoFDAb);
              $altoFD = $m->alto - 5;
              $altoFF = $m->alto;
            }
            $anchoFFAr = $anchoFFAr - 25;
            $anchoFFAb = $anchoFFAb - 25;
            break;

          case 'DIALAN':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 50;
              $altoFD = $m->alto - 60;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 50;
              $altoFD = $m->alto - 60;
            }
            break;

          case 'K1':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 50;
              $altoFD = $m->alto - 50;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 50;
              $altoFD = $m->alto - 50;
            }
            break;

          case 'K2':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 50;
              $altoFD = $m->alto - 50;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 50;
              $altoFD = $m->alto - 50;
            }
            break;

          case 'K3':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto;
              $altoFD = $m->alto - 55;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto;
              $altoFD = $m->alto - 55;
            }
            break;

          case 'K4':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto;
              $altoFD = $m->alto - 6;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto;
              $altoFD = $m->alto - 6;
            }
            break;

          case 'K7':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto;
              $altoFD = $m->alto - 55;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto;
              $altoFD = $m->alto - 55;
            }
            break;

          case 'TOGO':
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto - 20;
              $altoFD = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr + 40;
              $anchoFDAb = $anchoFFAb + 40;
              $altoFF = $m->alto -20;
              $altoFD = $m->alto;
            }
            break;

          default:
            if(abs($m->ancho2 - $m->ancho1) >= 20 ){
              $anchoFFAr = ($m->ancho2 / 2);
              $anchoFFAb = ($m->ancho1 / 2);
              $anchoFDAr = $anchoFFAr;
              $anchoFDAb = $anchoFFAb;
              $altoFF = $m->alto;
              $altoFD = $m->alto;
              $desc = true;
            }else{
              $anchoFFAr = ($anchoI / 2);
              $anchoFFAb = ($anchoI / 2);
              $anchoFDAr = $anchoFFAr;
              $anchoFDAb = $anchoFFAb;
              $altoFF = $m->alto;
              $altoFD = $m->alto;
            }
            break;
        }

        //guardar Medidas
        $medidaNueva1 = new MedidaVidrio();
        $medidaNueva1->mvdOrddID = $detalle->orddID;
        $medidaNueva1->mvdOrdID = $detalle->orddOrdenID;
        $medidaNueva1->mvdTipo = "Fijo";

        $medidaNueva2 = new MedidaVidrio();
        $medidaNueva2->mvdOrddID = $detalle->orddID;
        $medidaNueva2->mvdOrdID = $detalle->orddOrdenID;
        $medidaNueva2->mvdTipo = "Puerta";

        if($m->ladoPuerta == "Derecha"){
          $medidaNueva1->mvdLado = "Izquierda";
          $medidaNueva1->mvdAlto = $altoFF;
          $medidaNueva1->mvdAnchoArriba = $anchoFFAr;
          $medidaNueva1->mvdAnchoAbajo = $anchoFFAb;
          $medidaNueva2->mvdLado = "Derecha";
          $medidaNueva2->mvdAlto = $altoFD;
          $medidaNueva2->mvdAnchoArriba = $anchoFDAr;
          $medidaNueva2->mvdAnchoAbajo = $anchoFDAb;
        }else{
          $medidaNueva1->mvdLado = "Derecha";
          $medidaNueva1->mvdAlto = $altoFF;
          $medidaNueva1->mvdAnchoArriba = $anchoFFAr;
          $medidaNueva1->mvdAnchoAbajo = $anchoFFAb;
          $medidaNueva2->mvdLado = "Izquierda";
          $medidaNueva2->mvdAlto = $altoFD;
          $medidaNueva2->mvdAnchoArriba = $anchoFDAr;
          $medidaNueva2->mvdAnchoAbajo = $anchoFDAb;
        }

        $medidaNueva1->save();
        $medidaNueva2->save();

        //Actualizar datos de detalle y orden
        $orden = Orden::where("ordID", "=", $detalle->orddOrdenID)->first();
        $orden->ordEstadoInstalacionID = 2;
        $orden->save();
        date_default_timezone_set('America/Bogota');
        $detalle->orddFechaMedidas = date("Y-m-d");
        $detalle->orddEstadoMedidasID = 2;
        $detalle->orddAuxiliarID = Auth::user()->id;
        $detalle->orddLadoPuerta = $m->ladoPuerta;
        $detalle->orddObservacionesVidrio = $m->observaciones;
        $detalle->orddDescuadre = $desc;
        $detalle->save();

      }else{
        $detalle = OrdenDetalle::where("orddID", "=", $m->idDetalle)->first();

        //Actualizar razón negativa de orden detalle
        $detalle->orddFechaMedidas = date("Y-m-d");
        $detalle->orddRazonNegativa = $m->razonNegativa;
        $detalle->save();
      }
    }
  }

  private function recalcularPrecios($orden)
  {
    $detalles = OrdenDetalle::where("orddOrdenID", "=", $orden->ordID)->get();
    foreach ($detalles as $d) {
      //Cálculo del precio de venta con las nuevas medidas
      $medidas = MedidaVidrio::where("mvdOrddID", "=", $d->orddID)->get();
      $alto = max($medidas[0]->mvdAlto, $medidas[1]->mvdAlto);
      $ancho = max(($medidas[0]->mvdAnchoArriba + $medidas[1]->mvdAnchoArriba), ($medidas[0]->mvdAnchoAbajo + $medidas[1]->mvdAnchoAbajo));
      $stm = Sistema::where('stmID','=',$d->orddSistemaID)->first();
      $clr =  Color::where('clrID','=',$d->orddColorID)->first();
      $precio = PrecioVidrio::where('pvdMilimID','=',$d->orddMilimID)->where('pvdSistemaID','=',$d->orddSistemaID)->first();
      $precioVidrio = ($ancho*$alto*$precio->pvdPrecioVenta*(100-$d->orddDescuento))/100000000;
      $d->orddTotal = $this->roundUpToAny(($precioVidrio + $stm->stmPrecioVenta + $clr->clrPrecioVenta + $d->orddValorAdicional + ($d->orddCantToalleros*50000)),50);

      //Cálculo del precio de compra con las nuevas medidas
      $precioVidrioCompra = ($ancho*$alto*$precio->pvdPrecioCompra)/1000000;
      $d->orddTotalCompra = $this->roundUpToAny(($precioVidrioCompra + $stm->stmPrecioCompra + $clr->clrPrecioCompra + $d->orddValorAdicional + ($d->orddCantToalleros*50000)),50);
      $d->orddAlto = $alto;
      $d->orddAncho = $ancho;
      $d->save();
    }

    // Se calcula el precio total de compra y de venta para la orden
    $total = $totalCompra = 0;
    foreach($detalles as $d){
      $total = $total + $d->orddTotal;
      $totalCompra = $totalCompra + $d->orddTotalCompra;
    }

    // se establece el nuevo precio de compra, y el nuevo de venta si este es 50000 pesos más caro o barato que el inicial
    $orden->ordTotalCompra = $totalCompra;
    if(abs($total - $orden->ordTotal) >= 50000){
      $orden->ordTotal = $total;
      $orden->ordSaldo = $orden->ordTotal - $orden->ordAbono;
    }
    $orden->save();
  }

  public function generarPlanos($id)
  {
    //Obtener datos para el documento
    $orden = \App\Orden::where('ordID','=',$id)->first();
    $detalles = \App\OrdenDetalle::where('orddOrdenID','=',$id)->get();

    $relaciones = array('relacion');
    $cliente = \App\Cliente::where('cltID', '=', $orden->ordClienteID)->first();
    foreach ($detalles as $detalle) {
      $imagen = '';
      $generarPDF = true;
      $sistema = \App\Sistema::where('stmID', '=', $detalle->orddSistemaID)->first();
      $vidrios = \App\MedidaVidrio::where('mvdOrddID', '=', $detalle->orddID)->get();
      $diseno = \App\Diseno::where('dsnID', '=', $detalle->orddDisenoID)->first();
      $milimetraje = \App\Milimetraje::where('mlmID', '=', $detalle->orddMilimID)->first();
      $color = \App\Color::where('clrID', '=', $detalle->orddColorID)->first();
      $auxiliar = \App\User::where('id', '=', $detalle->orddAuxiliarID)->first();
      //foreach($vidrios as $vidrio){
        switch ($sistema->stmDescripcion) {
          case 'BATIENTE NORMAL TRASLAPADA':
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
              }
            }
            break;
          case 'BATIENTE NORMAL CHAFLAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_TOALLERO.jpg';
            }
          }
          case 'BATIENTE NORMAL IMAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
            break;
          case 'BATIENTE REDONDA TRASLAPADA':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE REDONDA CHAFLAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE REDONDA IMAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE ESQUINAS TRASLAPADA':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE ESQUINAS CHAFLAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE ESQUINAS IMAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE ARAÑA TRASLAPADA':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE ARAÑA CHAFLAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL CHAFLAN_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'BATIENTE ARAÑA IMAN':
          if($detalle->orddLadoPuerta == 'Izquierda'){
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_IZQUIERDA_TOALLERO.jpg';
            }
          }else{
            if($detalle->orddCantToalleros = 0){
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_NOTOALLERO.jpg';
            }else{
              $imagen = 'imagenes-medidas/BATIENTE NORMAL TRASLAPADA_DERECHA_TOALLERO.jpg';
            }
          }
            break;
          case 'DIALAN':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/DIALAN_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/DIALAN_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/DIALAN_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/DIALAN_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          case 'K1':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K1_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K1_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K1_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K1_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K1 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K1 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K1 EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K1 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K1 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K1 EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          case 'K2':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K2_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K2_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K2_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K2_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K2 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K2 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K2 EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K2 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K2 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K2 EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          case 'K3':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K3_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K3_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K3_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K3_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K3 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K3 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K3 EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K3 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K3 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K3 EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          case 'K4':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K4_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K4_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/K4_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/K4_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K4 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K4 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K4 EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/K4 EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/K4 EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/K4 EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          case 'K7':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/DIALAN_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/DIALAN_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/DIALAN_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/DIALAN_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          case 'TOGO':
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/TOGO_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/TOGO_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/TOGO_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/TOGO_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/TOGO EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/TOGO EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/TOGO EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/TOGO EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/TOGO EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/TOGO EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
          default:
          if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
            if($detalle->orddLadoPuerta == 'Izquierda'){
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/DIALAN_IZQUIERDA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/DIALAN_IZQUIERDA_TOALLERO.jpg';
              }
            }else{
              if($detalle->orddCantToalleros = 0){
                $imagen = 'imagenes-medidas/DIALAN_DERECHA_NOTOALLERO.jpg';
              }else{
                $imagen = 'imagenes-medidas/DIALAN_DERECHA_TOALLERO.jpg';
              }
            }
          }else{
            if(!in_array('relacion', $detalle->orddRelacion)){
              if($detalle->orddLadoPuerta == 'Izquierda'){
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_TOALLERO IZQ.jpg';
                }
              }else{
                if($detalle->orddCantToalleros = 0){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_NOTOALLERO.jpg';
                }elseif($detalle->orddCantToalleros = 2){
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_2 TOALLEROS.jpg';
                }else{
                  $imagen = 'imagenes-medidas/DIALAN EN L_2 PUERTAS_TOALLERO DER.jpg';
                }
              }
              $relaciones[] = $detalle->orddRelacion;
            }else{
              $generarPDF = false;
            }
          }
            break;
        //}
      }
      if($generarPDF){

        if($detalle->orddRelacion == null || $detalle->orddRelacion == ''){
          foreach($vidrios as $vidrio){
            if($vidrio->mvdTipo == 'Fijo'){
              $vidrioF = $vidrio;
            }else{
              $vidrioP = $vidrio;
            }
          }
          return $this->generarPlanosPDF($orden, $detalle, $id, $auxiliar,
                                  $sistema, $color, $milimetraje, $diseno,
                                  $cliente, $imagen, $vidrioF, $vidrioP);
        }else{
          $f = 1;
          $p = 1;
          foreach($vidrios as $vidrio){
            if($vidrio->mvdTipo == 'Fijo'){
              if($f == 1){
                $vidrioF1 = $vidrio;
                $f++;
              }else{
                $vidrioF2 = $vidrio;
              }
            }else{
              if($p == 1){
                $vidrioP1 = $vidrio;
                $p++;
              }else{
                $vidrioP2 = $vidrio;
              }
            }
          }
          $this->generarPlanosPDFL($orden, $detalle, $id, $auxiliar,
                                  $sistema, $color, $milimetraje, $diseno,
                                  $cliente, $imagen, $vidrioF1, $vidrioP1,
                                  $vidrioF2, $vidrioP2);
        }
      }
    }
    //return Redirect::to('/')->with('success', 'Planos generados existosamente');
  }

  public function generarPlanosPDF($orden, $detalle, $id, $auxiliar,
                                  $sistema, $color, $milimetraje, $diseno,
                                  $cliente, $imagen, $vidrioF, $vidrioP){
    //Generar planos
    $pdf = PDF::loadView('medidas/generarPlanosPdf', [
      'orden' => $orden,
      'detalle' => $detalle,
      'id' => $id,
      'auxiliar' => $auxiliar,
      'sistema' => $sistema,
      'color' => $color,
      'milimetraje' => $milimetraje,
      'diseno' => $diseno,
      'cliente' => $cliente,
      'imagen' => $imagen,
      'vidrioF' => $vidrioF,
      'vidrioP' => $vidrioP
    ]);
    return $pdf->download('Planos de medidas N'.$id.'.pdf');
  }

  public function generarPlanosPDFL($orden, $detalle, $id, $auxiliar,
                                  $sistema, $color, $milimetraje, $diseno,
                                  $cliente, $imagen, $vidrioF1, $vidrioP1,
                                  $vidrioF2, $vidrioP2){
    //Generar planos
    $pdf = PDF::loadView('medidas/generarPlanosPdfL', [
      'orden' => $orden,
      'detalle' => $detalle,
      'id' => $id,
      'auxiliar' => $auxiliar,
      'sistema' => $sistema,
      'color' => $color,
      'milimetraje' => $milimetraje,
      'diseno' => $diseno,
      'cliente' => $cliente,
      'imagen' => $imagen,
      'vidrioF1' => $vidrioF1,
      'vidrioP1' => $vidrioP1,
      'vidrioF2' => $vidrioF2,
      'vidrioP2' => $vidrioP2
    ]);
    return $pdf->download('Planos de medidas N'.$id.'.pdf');
  }

  public function cancel()
  {
    if(Request::session()->has('orden') && Request::session()->has('medidas') && Auth::user()->usrRolID==3){
      Request::session()->put('orden', null);
      Request::session()->put('medidas', null);
    }
    return Redirect::to('/');
  }

  private function roundUpToAny($n,$x=5) {
    return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
  }

}
