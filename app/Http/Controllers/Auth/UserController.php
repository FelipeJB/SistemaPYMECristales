<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class UserController extends Controller
{

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $usuario= \App\User::where('id','=',$id)->get()[0];
        if($usuario->usrRolID==1){
          return Redirect::to('/AdministrarUsuarios')->with("error", "No se puede desactivar un usuario administrador");
        }
        else{
          $usuario->usrActivo=0;
          $usuario->save();
          return Redirect::to('/AdministrarUsuarios')->with("success", "El usuario se desactivó satisfactoriamente");
        }
      }
      else{
        return Redirect::to('/');
      }
    } catch (Exception $e) {
      return Redirect::to('/AdministrarUsuarios')->with("error", "Error desactivando el usuario");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $usuario= \App\User::where('id','=',$id)->get()[0];
        $usuario->usrActivo=1;
        $usuario->save();
        return Redirect::to('/AdministrarUsuarios')->with("success", "El usuario se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (Exception $e) {
      return Redirect::to('/AdministrarUsuarios')->with("error", "Error activando el usuario");
    }
  }



}
