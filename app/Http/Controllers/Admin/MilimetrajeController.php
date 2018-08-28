<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Milimetraje;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MilimetrajeController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del milimetraje dentro de variables desde el formulario*/
      $numero = Input::get('numero');

      //validar que se ingresen tods los datos
      if($numero == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar número numérico
      if(!is_numeric($numero)){
        return Redirect::back()->with('numero', 'Ingrese un número válido')
        ->withInput();
      }

      try{
        //creación del milimetraje
        $newMilimetraje = new Milimetraje();
        $newMilimetraje->mlmNumero = $numero;
        $newMilimetraje->mlmActivo = 1;
        $newMilimetraje->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarMilimetrajes')->with('success', 'El milimetraje se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::back()->with('error', 'El milimetraje no pudo ser registrado')->withInput();
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
        return Redirect::to('/AdministrarMilimetrajes')->with('success', 'El diseño se modificó exitosamente');

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
        $milimetraje= Milimetraje::where('mlmID','=',$id)->first();
        $milimetraje->mlmActivo=0;
        $milimetraje->save();
        return Redirect::to('/AdministrarMilimetrajes')->with("success", "El milimetraje se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarMilimetrajes')->with("error", "Error desactivando el milimetraje");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $milimetraje= Milimetraje::where('mlmID','=',$id)->first();
        $milimetraje->mlmActivo=1;
        $milimetraje->save();
        return Redirect::to('/AdministrarMilimetrajes')->with("success", "El milimetraje se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarMilimetrajes')->with("error", "Error activando el milimetraje");
    }
  }

}
