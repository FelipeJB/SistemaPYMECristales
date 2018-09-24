<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Sistema;
use App\Milimetraje;
use App\PrecioVidrio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SistemaController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del sistema dentro de variables desde el formulario*/
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
      $tipo = Input::get('tipo');
      $precioCompra = Input::get('precioCompra');
      $precioVenta = Input::get('precioVenta');
      $perforaciones = Input::get('perforaciones');
      $boquetes = Input::get('boquetes');
      $bpb = Input::get('bpb');
      $chaflan = Input::get('chaflan');

      //validar que se ingresen todos los datos
      if($codigo == "" || $descripcion == "" || $precioCompra == "" || $precioVenta == "" || $perforaciones == "" || $boquetes == "" || $bpb == "" || $chaflan == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar precio compra numérico
      if(!is_numeric($precioCompra)){
        return Redirect::back()->with('precioCompra', 'Ingrese un precio válido')
        ->withInput();
      }

      //validar precio venta numérico
      if(!is_numeric($precioVenta)){
        return Redirect::back()->with('precioVenta', 'Ingrese un precio válido')
        ->withInput();
      }

      //validar perforaciones numéricas
      if(!is_numeric($perforaciones)){
        return Redirect::back()->with('perforaciones', 'Ingrese una cantidad de perforaciones válida')
        ->withInput();
      }

      //validar boquetes numéricos
      if(!is_numeric($boquetes)){
        return Redirect::back()->with('boquetes', 'Ingrese una cantidad de boquetes válida')
        ->withInput();
      }

      //validar bpb numéricos
      if(!is_numeric($bpb)){
        return Redirect::back()->with('bpb', 'Ingrese una cantidad de BPB válida')
        ->withInput();
      }

      //validar chaflán numéricos
      if(!is_numeric($chaflan)){
        return Redirect::back()->with('chaflan', 'Ingrese una cantidad de chaflán válida')
        ->withInput();
      }

      try{
        //creación del sistema
        $newSistema = new Sistema();
        $newSistema->stmTipo = $tipo;
        $newSistema->stmCodigoWO = $codigo;
        $newSistema->stmDescripcion = $descripcion;
        $newSistema->stmPrecioCompra = $precioCompra;
        $newSistema->stmPrecioVenta = $precioVenta;
        $newSistema->stmCantPerforaciones = $perforaciones;
        $newSistema->stmCantBoquetes = $boquetes;
        $newSistema->stmCantBPB = $bpb;
        $newSistema->stmCantChaflan = $chaflan;
        $newSistema->stmActivo = 1;
        $newSistema->save();

        //creación de precios
        $milimetrajes=Milimetraje::select('mlmID')->get();
        foreach($milimetrajes as $m){
          $precio = new PrecioVidrio();
          $precio->pvdMilimID = $m->mlmID;
          $precio->pvdSistemaID = $newSistema->stmID;
          $precio->pvdPrecioCompra = 0;
          $precio->pvdPrecioVenta = 0;
          $precio->save();
        }

        //redirigir a la página de administración
        return Redirect::to('/AdministrarSistemas')->with('success', 'El sistema se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::back()->with('error', 'El sistema no pudo ser registrado')->withInput();
      }

  }

  public function edit()
  {
      /*Se guardan los datos del sistema dentro de variables desde el formulario*/
      $id = Input::get('stmID');
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
      $tipo = Input::get('tipo');
      $precioCompra = Input::get('precioCompra');
      $precioVenta = Input::get('precioVenta');
      $perforaciones = Input::get('perforaciones');
      $boquetes = Input::get('boquetes');
      $bpb = Input::get('bpb');
      $chaflan = Input::get('chaflan');

      //validar que se ingresen tods los datos
      if($codigo == "" || $descripcion == "" || $precioCompra == "" || $precioVenta == "" || $perforaciones == "" || $boquetes == "" || $bpb == "" || $chaflan == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar precio compra numérico
      if(!is_numeric($precioCompra)){
        return Redirect::back()->with('precioCompra', 'Ingrese un precio válido')
        ->withInput();
      }

      //validar precio venta numérico
      if(!is_numeric($precioVenta)){
        return Redirect::back()->with('precioVenta', 'Ingrese un precio válido')
        ->withInput();
      }

      //validar perforaciones numéricas
      if(!is_numeric($perforaciones)){
        return Redirect::back()->with('perforaciones', 'Ingrese una cantidad de perforaciones válida')
        ->withInput();
      }

      //validar boquetes numéricos
      if(!is_numeric($boquetes)){
        return Redirect::back()->with('boquetes', 'Ingrese una cantidad de boquetes válida')
        ->withInput();
      }

      //validar bpb numéricos
      if(!is_numeric($bpb)){
        return Redirect::back()->with('bpb', 'Ingrese una cantidad de BPB válida')
        ->withInput();
      }

      //validar chaflán numéricos
      if(!is_numeric($chaflan)){
        return Redirect::back()->with('chaflan', 'Ingrese una cantidad de chaflán válida')
        ->withInput();
      }

      try{
        //guardar sistema
        $sistema = Sistema::where('stmID','=',$id)->first();
        $sistema->stmCodigoWO = $codigo;
        $sistema->stmTipo = $tipo;
        $sistema->stmDescripcion = $descripcion;
        $sistema->stmPrecioCompra = $precioCompra;
        $sistema->stmPrecioVenta = $precioVenta;
        $sistema->stmCantPerforaciones = $perforaciones;
        $sistema->stmCantBoquetes = $boquetes;
        $sistema->stmCantBPB = $bpb;
        $sistema->stmCantChaflan = $chaflan;
        $sistema->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarSistemas')->with('success', 'El sistema se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El sistema no pudo ser modificado')->withInput();
      }

  }

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $sistema= Sistema::where('stmID','=',$id)->first();
        $sistema->stmActivo=0;
        $sistema->save();
        return Redirect::to('/AdministrarSistemas')->with("success", "El sistema se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarSistemas')->with("error", "Error desactivando el sistema");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $sistema= Sistema::where('stmID','=',$id)->first();
        $sistema->stmActivo=1;
        $sistema->save();
        return Redirect::to('/AdministrarSistemas')->with("success", "El sistema se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarSistemas')->with("error", "Error activando el sistema");
    }
  }

}
