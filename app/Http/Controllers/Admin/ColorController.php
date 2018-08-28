<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ColorController extends Controller
{

  public function create()
  {
      /*Se guardan los datos del color dentro de variables desde el formulario*/
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
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
        //creación del color
        $newColor = new Color();
        $newColor->clrCodigo = $codigo;
        $newColor->clrDescripcion = $descripcion;
        $newColor->clrPrecioCompra = $precioCompra;
        $newColor->clrPrecioVenta = $precioVenta;
        $newColor->clrActivo = 1;
        $newColor->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarColores')->with('success', 'El color se registró exitosamente');

      }catch(\Exception $exception){
        return Redirect::to('/AdministrarColores')->with('error', 'El color no pudo ser registrado')->withInput();
      }

  }

  public function edit()
  {
      /*Se guardan los datos del color dentro de variables desde el formulario*/
      $id = Input::get('clrID');
      $codigo = Input::get('codigo');
      $descripcion = Input::get('descripcion');
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
        //guardar color
        $color = Color::where('clrID','=',$id)->first();
        $color->clrCodigo = $codigo;
        $color->clrDescripcion = $descripcion;
        $color->clrPrecioCompra = $precioCompra;
        $color->clrPrecioVenta = $precioVenta;
        $color->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarColores')->with('success', 'El color se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(Exception $exception){
        return Redirect::back()->with('error', 'El color no pudo ser modificado')->withInput();
      }

  }

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $color= Color::where('clrID','=',$id)->first();
        $color->clrActivo=0;
        $color->save();
        return Redirect::to('/AdministrarColores')->with("success", "El color se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarColores')->with("error", "Error desactivando el color");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $color= Color::where('clrID','=',$id)->first();
        $color->clrActivo=1;
        $color->save();
        return Redirect::to('/AdministrarColores')->with("success", "El color se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarColores')->with("error", "Error activando el color");
    }
  }

}
