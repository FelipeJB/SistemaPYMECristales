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
      /*Se guardan los datos del sistemaDetalle dentro de variables desde el formulario*/
      $idSistema = Input::get('stmID');
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
      $cantidad = Input::get('cantidad');

      //validar que se ingresen todos los datos
      if($codigo == "" || $descripcion == "" || $cantidad == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar cantidad numérica
      if(!is_numeric($cantidad)){
        return Redirect::back()->with('cantidad', 'Ingrese una cantidad válida')
        ->withInput();
      }

      try{
        //creación del sistemaDetalle
        $newSistemaD = new SistemaDetalle();
        $newSistemaD->stmdSistemaID = $idSistema;
        $newSistemaD->stmdCodigoWO = $codigo;
        $newSistemaD->stmdDescripcion = $descripcion;
        $newSistemaD->stmdCantidad = $cantidad;
        $newSistemaD->stmdActivo = 1;
        $newSistemaD->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarSistemas/Elementos/'.$idSistema)->with('success', 'El elemento se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::back()->with('error', 'El elemento no pudo ser registrado')->withInput();
      }

  }

  public function edit()
  {
      /*Se guardan los datos del sistemaDetalle dentro de variables desde el formulario*/
      $id = Input::get('stmdID');
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
      $cantidad = Input::get('cantidad');

      //validar que se ingresen tods los datos
      if($codigo == "" || $descripcion == "" || $cantidad == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar cantidad numérica
      if(!is_numeric($cantidad)){
        return Redirect::back()->with('cantidad', 'Ingrese una cantidad válida')
        ->withInput();
      }

      try{
        //guardar sistemaDetalle
        $sistemaD = SistemaDetalle::where('stmdID','=',$id)->first();
        $sistemaD->stmdCodigoWO = $codigo;
        $sistemaD->stmdDescripcion = $descripcion;
        $sistemaD->stmdCantidad = $cantidad;
        $sistemaD->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarSistemas/Elementos/'.$sistemaD->stmdSistemaID)->with('success', 'El elemento se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El elemento no pudo ser modificado')->withInput();
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
