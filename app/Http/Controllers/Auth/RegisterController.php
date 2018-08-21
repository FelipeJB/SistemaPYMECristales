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
      $apellido = Input::get('apellido');
      $username = Input::get('username');
      $tipoDocumento = Input::get('tipoDocumento');
      $cedula = Input::get('cedula');
      $rol = Input::get('rol');
      $password = Input::get('password');
      $passwordConfirm = Input::get('passwordConfirm');
      $ciudad = Input::get('ciudad');
      $celular = Input::get('celular');
      $dir0 = Input::get('direccion-avenida');
      $dir1 = Input::get('direccion-1');
      $dir2 = Input::get('direccion-2');
      $dir3 = Input::get('direccion-3');
      $dir4 = Input::get('direccion-detalle');


      //validar que se ingresen tods los datos
      if($nombre == "" || $username == "" || $cedula == "" || $password == "" || $password == "" || $apellido == "" || $celular == "" || $dir1 == "" || $dir2 == "" || $dir3 == ""){
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
        $newUser->usrApellido = $apellido;
        $newUser->usrUsuario = $username;
        $newUser->usrTipoDocumento = $tipoDocumento;
        $newUser->usrCedula = $cedula;
        $newUser->usrCelular = $celular;
        $newUser->usrCiudad = $ciudad;
        $newUser->usrDireccion = $dir0." ".$dir1."#".$dir2."-".$dir3." ".$dir4;
        $newUser->usrRolID = $rol;
        $newUser->password = Hash::make($password);
        $newUser->usrActivo = 1;
        $newUser->usrFechaCreacion = date("Y-m-d");
        $newUser->save();

        //redirigir a la página de registro
        return Redirect::back()->with('success', 'El usuario se registró exitosamente');

      }catch(Exception $exception){
        return Redirect::back()->with('error', 'El usuario no pudo ser registrado')->withInput();
      }


  }


}
