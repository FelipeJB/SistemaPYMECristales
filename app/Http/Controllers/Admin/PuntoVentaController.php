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

}
