<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

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
    } catch (\Exception $e) {
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
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarUsuarios')->with("error", "Error activando el usuario");
    }
  }

  public function edit()
  {
      /*Se guardan los datos del usuario dentro de variables desde el formulario*/
      $nombre = Input::get('name');
      $apellido = Input::get('apellido');
      $username = Input::get('username');
      $tipoDocumento = Input::get('tipoDocumento');
      $cedula = Input::get('cedula');
      $rol = Input::get('rol');
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
        //guardar usuario
        $user = User::where('usrUsuario','=',$username)->first();
        $user->usrNombre = $nombre;
        $user->usrApellido = $apellido;
        $user->usrTipoDocumento = $tipoDocumento;
        $user->usrCedula = $cedula;
        $user->usrCelular = $celular;
        $user->usrCiudad = $ciudad;
        $user->usrDireccion = $dir0." ".$dir1."#".$dir2."-".$dir3.".".$dir4;
        $user->usrRolID = $rol;
        $user->save();

        //redirigir a la página de administración
        return Redirect::to('/AdministrarUsuarios')->with('success', 'El usuario se modificó exitosamente');

      }catch(\Illuminate\Database\QueryException $exception){
        return Redirect::back()->with('error', 'Error en la base de datos')->withInput();
      }
      catch(\Exception $exception){
        return Redirect::back()->with('error', 'El usuario no pudo ser modificado')->withInput();
      }

  }

  public function editPassword()
    {
        /*Se guardan los datos del usuario dentro de variables desde el formulario*/
        $contraVieja = Input::get('passwordNow');
        $contraNueva1 = Input::get('password');
        $contraNueva2 = Input::get('passwordConfirm');

        if (Hash::check($contraVieja, Auth::user()->password)) {

          //validar contraseñas iguales
          if($contraNueva1 != $contraNueva2){
            return Redirect::back()->with("password", "Las contraseñas nuevas no coinciden");
          }

          //validar 6 caracteres mínimo
          else if(strlen($contraNueva1)<6){
            return Redirect::back()->with("password", "La contraseña debe tener 6 caracteres o más");
          }

          else{
          $user = Auth::user();
          $user->password=Hash::make($contraNueva1);
          $user->save();
          return Redirect::to('/')->with("success", "La contraseña se modificó exitosamente");;
          }

        }
        else{
          return Redirect::back()->with("passwordNow", "Contraseña actual incorrecta");
        }

    }



}
