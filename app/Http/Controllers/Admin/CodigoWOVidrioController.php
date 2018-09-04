<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\CodigoWoVidrio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CodigoWOVidrioController extends Controller
{

  public function edit()
  {
      /*Se guardan los datos del código dentro de variables desde el formulario*/
      $id = Input::get('cdgID');
      $codigo = Input::get('codigo');

      //validar que se ingresen tods los datos
      if($codigo == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      try{
        //guardar código
        $codigoWO = CodigoWoVidrio::where('cdgID','=',$id)->first();
        $codigoWO->cdgWO = $codigo;
        $codigoWO->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarCodigos')->with('success', 'El código se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El código no pudo ser modificado')->withInput();
      }

  }

}
