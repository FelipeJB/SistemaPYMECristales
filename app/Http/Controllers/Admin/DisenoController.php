<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Diseno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DisenoController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del diseño dentro de variables desde el formulario*/
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');

      //validar que se ingresen tods los datos
      if($codigo == "" || $descripcion == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      try{
        //creación del diseño
        $newDiseno = new Diseno();
        $newDiseno->dsnCodigo = $codigo;
        $newDiseno->dsnDescripcion = $descripcion;
        $newDiseno->dsnActivo = 1;
        $newDiseno->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarDisenos')->with('success', 'El diseño se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::to('/AdministrarDisenos')->with('error', 'El diseño no pudo ser registrado')->withInput();
      }

  }

  public function edit()
  {
      /*Se guardan los datos del diseño dentro de variables desde el formulario*/
      $id = Input::get('dsnID');
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');

      //validar que se ingresen tods los datos
      if($codigo == "" || $descripcion == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      try{
        //guardar diseño
        $diseno = Diseno::where('dsnID','=',$id)->first();
        $diseno->dsnCodigo = $codigo;
        $diseno->dsnDescripcion = $descripcion;
        $diseno->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarDisenos')->with('success', 'El diseño se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El diseño no pudo ser modificado')->withInput();
      }

  }

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $diseno= Diseno::where('dsnID','=',$id)->first();
        $diseno->dsnActivo=0;
        $diseno->save();
        return Redirect::to('/AdministrarDisenos')->with("success", "El diseño se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarDisenos')->with("error", "Error desactivando el diseño");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $diseno= Diseno::where('dsnID','=',$id)->first();
        $diseno->dsnActivo=1;
        $diseno->save();
        return Redirect::to('/AdministrarDisenos')->with("success", "El diseño se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarDisenos')->with("error", "Error activando el diseño");
    }
  }

}
