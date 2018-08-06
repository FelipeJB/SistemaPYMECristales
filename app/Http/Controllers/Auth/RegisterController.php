<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class RegisterController extends Controller
{

  public function registro()
  {
      /*Se guardan los datos del usuario dentro de variables desde el formulario*/
      $nombre = Input::get('name');
      $username = Input::get('username');
      $cedula = Input::get('cedula');
      $rol = Input::get('rol');
      $password = Input::get('password');
      $passwordConfirm = Input::get('passwordConfirm');


      //validar que se ingresen tods los datos
      if($nombre == "" || $username == "" || $cedula == "" || $password == "" || $password == ""){
        return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
        ->withInput();
      }

      //validar contraseña mayor a 6 dígitos
      if(strlen($password)<6){
        return Redirect::back()->with('password', 'La contraseña debe ser mayor a 6 dígitos')
        ->withInput();
      }

      //validar contraseñas iguales
      if($password != $passwordConfirm){
        return Redirect::back()->with('passwordConfirm', 'Las contraseñas deben coincidir')
        ->withInput();
      }

      //validar nombre de usuario no registrado
      $isRegistered = User::where("usrUsuario", "=", $username)->get();
      if (sizeof($isRegistered) != 0){
        return Redirect::back()->with('username', 'El nombre de usuario ya se encuentra registrado')
        ->withInput();
      }

      //validar cédula numérica
      if(!is_numeric($cedula)){
        return Redirect::back()->with('cedula', 'Ingrese una cédula válida')
        ->withInput();
      }

      try{
        //hacer registro
        $newUser = new User();
        $newUser->usrNombre = $nombre;
        $newUser->usrUsuario = $username;
        $newUser->usrCedula = $cedula;
        $newUser->usrRolID = $rol;
        $newUser->password = Hash::make($password);
        $newUser->save();

        //redirigir a la página de registro
        return Redirect::back()->with('success', 'El usuario se registró exitosamente');

      }catch(Exception $exception){
        return Redirect::back()->with('error', 'El usuario no pudo ser registrado')->withInput();
      }


  }


}
