<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Instalador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class InstaladorController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del instalador dentro de variables desde el formulario*/
      $nombre = Input::get('name');
      $apellido = Input::get('apellido');
      $tipoDocumento = Input::get('tipoDocumento');
      $cedula = Input::get('cedula');
      $ciudad = Input::get('ciudad');
      $celular = Input::get('celular');
      $dir0 = Input::get('direccion-avenida');
      $dir1 = Input::get('direccion-1');
      $dir2 = Input::get('direccion-2');
      $dir3 = Input::get('direccion-3');
      $dir4 = Input::get('direccion-detalle');

      //validar que se ingresen tods los datos
      if($nombre == "" || $cedula == "" || $apellido == "" || $celular == "" || $dir1 == "" || $dir2 == "" || $dir3 == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar cédula numérica
      if(!is_numeric($cedula)){
        return Redirect::back()->with('cedula', 'Ingrese una cédula válida')
        ->withInput();
      }

      try{
        //creación del instalador
        $newIns = new Instalador();
        $newIns->insNombre = $nombre;
        $newIns->insApellido = $apellido;
        $newIns->insTipoDocumento = $tipoDocumento;
        $newIns->insCedula = $cedula;
        $newIns->insCelular = $celular;
        $newIns->insCiudad = $ciudad;
        $newIns->insDireccion = $dir0." ".$dir1."#".$dir2."-".$dir3.".".$dir4;
        $newIns->insActivo = 1;
        $newIns->insFechaCreacion = date("Y-m-d");
        $newIns->save();

        //redirigir a la página de registro
        return Redirect::back()->with('success', 'El instalador se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::back()->with('error', 'El instalador no pudo ser registrado')->withInput();
      }

  }

  public function edit()
  {
      /*Se guardan los datos del instalador dentro de variables desde el formulario*/
      $id = Input::get('insID');
      $nombre = Input::get('name');
      $apellido = Input::get('apellido');
      $tipoDocumento = Input::get('tipoDocumento');
      $cedula = Input::get('cedula');
      $ciudad = Input::get('ciudad');
      $celular = Input::get('celular');
      $dir0 = Input::get('direccion-avenida');
      $dir1 = Input::get('direccion-1');
      $dir2 = Input::get('direccion-2');
      $dir3 = Input::get('direccion-3');
      $dir4 = Input::get('direccion-detalle');

      //validar que se ingresen tods los datos
      if($nombre == "" || $cedula == "" || $apellido == "" || $celular == "" || $dir1 == "" || $dir2 == "" || $dir3 == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar cédula numérica
      if(!is_numeric($cedula)){
        return Redirect::back()->with('cedula', 'Ingrese una cédula válida')
        ->withInput();
      }

      try{
        //guardar instalador
        $instalador = Instalador::where('insID','=',$id)->first();
        $instalador->insNombre = $nombre;
        $instalador->insApellido = $apellido;
        $instalador->insTipoDocumento = $tipoDocumento;
        $instalador->insCedula = $cedula;
        $instalador->insCelular = $celular;
        $instalador->insCiudad = $ciudad;
        $instalador->insDireccion = $dir0." ".$dir1."#".$dir2."-".$dir3.".".$dir4;
        $instalador->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarInstaladores')->with('success', 'El instalador se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El instalador no pudo ser modificado')->withInput();
      }

  }

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $instalador= Instalador::where('insID','=',$id)->first();
        $instalador->insActivo=0;
        $instalador->save();
        return Redirect::to('/AdministrarInstaladores')->with("success", "El instalador se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarInstaladores')->with("error", "Error desactivando el instalador");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $instalador= Instalador::where('insID','=',$id)->first();
        $instalador->insActivo=1;
        $instalador->save();
        return Redirect::to('/AdministrarInstaladores')->with("success", "El instalador se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarInstaladores')->with("error", "Error activando el instalador");
    }
  }

}
