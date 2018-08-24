<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\PuntoVenta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class PuntoVentaController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del punto de venta dentro de variables desde el formulario*/
      $nombre = Input::get('name');
      $dir0 = Input::get('direccion-avenida');
      $dir1 = Input::get('direccion-1');
      $dir2 = Input::get('direccion-2');
      $dir3 = Input::get('direccion-3');
      $dir4 = Input::get('direccion-detalle');

      //validar que se ingresen tods los datos
      if($nombre == "" || $dir1 == "" || $dir2 == "" || $dir3 == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      try{
        //creación del punto de venta
        $newPunto = new PuntoVenta();
        $newPunto->pvNombre = $nombre;
        $newPunto->pvDireccion = $dir0." ".$dir1."#".$dir2."-".$dir3.".".$dir4;
        $newPunto->pvActivo = 1;
        $newPunto->save();

        //redirigir a la página de registro
        return Redirect::back()->with('success', 'El punto de venta se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::back()->with('error', 'El punto de venta no pudo ser registrado')->withInput();
      }

  }

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $punto= PuntoVenta::where('pvID','=',$id)->first();
        $punto->pvActivo=0;
        $punto->save();
        return Redirect::to('/AdministrarPuntos')->with("success", "El punto de venta se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarPuntos')->with("error", "Error desactivando el punto de venta");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $punto= PuntoVenta::where('pvID','=',$id)->first();
        $punto->pvActivo=1;
        $punto->save();
        return Redirect::to('/AdministrarPuntos')->with("success", "El punto de venta se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarPuntos')->with("error", "Error activando el punto de venta");
    }
  }

}
