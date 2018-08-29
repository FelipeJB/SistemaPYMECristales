<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\SistemaDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SistemaDetalleController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del sistema dentro de variables desde el formulario*/
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
      $tipo = Input::get('tipo');
      $precioCompra = Input::get('precioCompra');
      $precioVenta = Input::get('precioVenta');

      //validar que se ingresen todos los datos
      if($codigo == "" || $descripcion == "" || $precioCompra == "" || $precioVenta == ""){
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

      try{
        //creación del sistema
        $newSistema = new Sistema();
        $newSistema->stmTipo = $tipo;
        $newSistema->stmCodigoWO = $codigo;
        $newSistema->stmDescripcion = $descripcion;
        $newSistema->stmPrecioCompra = $precioCompra;
        $newSistema->stmPrecioVenta = $precioVenta;
        $newSistema->stmActivo = 1;
        $newSistema->save();

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

      //validar que se ingresen tods los datos
      if($codigo == "" || $descripcion == "" || $precioCompra == "" || $precioVenta == ""){
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

      try{
        //guardar sistema
        $sistema = Sistema::where('stmID','=',$id)->first();
        $sistema->stmCodigoWO = $codigo;
        $sistema->stmTipo = $tipo;
        $sistema->stmDescripcion = $descripcion;
        $sistema->stmPrecioCompra = $precioCompra;
        $sistema->stmPrecioVenta = $precioVenta;
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
        $sistemaDetalle= SistemaDetalle::where('stmdID','=',$id)->first();
        if($sistemaDetalle->stmdSistemaID!=$request->idSistema){
          return Redirect::to('/AdministrarSistemas/Elementos/'.$request->idSistema)->with("error", "Solicitud Inválida");
        }
        $sistemaDetalle->stmdActivo=0;
        $sistemaDetalle->save();
        return Redirect::to('/AdministrarSistemas/Elementos/'.$request->idSistema)->with("success", "El elemento se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarSistemas/Elementos/'.$request->idSistema)->with("error", "Error desactivando el elemento");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $sistemaDetalle= SistemaDetalle::where('stmdID','=',$id)->first();
        if($sistemaDetalle->stmdSistemaID!=$request->idSistema){
          return Redirect::to('/AdministrarSistemas/Elementos/'.$request->idSistema)->with("error", "Solicitud Inválida");
        }
        $sistemaDetalle->stmdActivo=1;
        $sistemaDetalle->save();
        return Redirect::to('/AdministrarSistemas/Elementos/'.$request->idSistema)->with("success", "El elemento se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarSistemas/Elementos/'.$request->idSistema)->with("error", "Error activando el elemento");
    }
  }

}
