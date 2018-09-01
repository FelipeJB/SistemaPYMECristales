<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\PrecioVidrio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class PrecioVidrioController extends Controller
{

  public function edit()
  {
      /*Se guardan los datos del precio dentro de variables desde el formulario*/
      $id = Input::get('pvdID');
      $precioCompra = Input::get('precioCompra');
      $precioVenta = Input::get('precioVenta');

      //validar que se ingresen tods los datos
      if($precioCompra == "" || $precioVenta == ""){
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
        //guardar precio
        $precio = PrecioVidrio::where('pvdID','=',$id)->first();
        $precio->pvdPrecioCompra = $precioCompra;
        $precio->pvdPrecioVenta = $precioVenta;
        $precio->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarPrecios')->with('success', 'El precio se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El precio no pudo ser modificado')->withInput();
      }

  }

}
