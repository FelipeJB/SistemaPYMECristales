<?php

namespace App\Http\Controllers\Ventas;

use Auth;
use App\Cliente;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{

  public function create()
  {
    /*Se guardan los datos del cliente dentro de variables desde el formulario*/
    $nombre = Input::get('name');
    $apellido = Input::get('apellido');
    $tipoDocumento = Input::get('tipoDocumento');
    $cedula = Input::get('cedula');
    $ciudad = Input::get('ciudad');
    $email = Input::get('email');
    $celular1 = Input::get('celular');
    $celular2 = Input::get('celular2');
    $dir0 = Input::get('direccion-avenida');
    $dir1 = Input::get('direccion-1');
    $dir2 = Input::get('direccion-2');
    $dir3 = Input::get('direccion-3');
    $dir4 = Input::get('direccion-detalle');
    $ica = Input::get('ica');
    $tipo = Input::get('tipoCliente');

    //validar que se ingresen tods los datos
    if($nombre == "" || $cedula == "" || $apellido == "" || $celular1 == "" || $email == "" || $dir1 == "" || $dir2 == "" || $dir3 == "" || $ica == ""){
      return Redirect::back()->with('error', 'Se deben ingresar todos los datos')
      ->withInput();
    }

    //validar cédula numérica
    if(!is_numeric($cedula)){
      return Redirect::back()->with('cedula', 'Ingrese una cédula válida')
      ->withInput();
    }

    //validar cédula no registrada
    $isRegistered = Cliente::where("cltCedula", "=", $cedula)->get();
    if (sizeof($isRegistered) != 0){
      return Redirect::back()->with('cedula', 'Ya se encuentra registrado un cliente con este documento')
      ->withInput();
    }

    //validar email válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return Redirect::back()->with('email', 'Ingrese un email válido')
      ->withInput();
    }

    //validar tarifa ica numérica
    if(!is_numeric($ica)){
      return Redirect::back()->with('ica', 'Ingrese una tarifa válida')
      ->withInput();
    }

    try{
      //creación del cliente
      $newCliente = new Cliente();
      $newCliente->cltNombre = $nombre;
      $newCliente->cltApellido = $apellido;
      $newCliente->cltEmail = $email;
      $newCliente->cltTipoDocumento = $tipoDocumento;
      $newCliente->cltCedula = $cedula;
      $newCliente->cltCelular1 = $celular1;
      $newCliente->cltCelular2 = $celular2;
      $newCliente->cltCiudad = $ciudad;
      $newCliente->cltDireccion = $dir0." ".$dir1."#".$dir2."-".$dir3.".".$dir4;
      $newCliente->cltTipoCliente = $tipo;
      $newCliente->cltTarifaICA = $ica;
      $newCliente->cltMigrado = 0;
      $newCliente->cltUsuarioCreador = Auth::user()->id;
      $newCliente->cltFechaCreacion = date("Y-m-d");

      //guardado del cliente en sesión y redirección al siguiente formulario
      Request::session()->put('cliente', $newCliente);
      return Redirect::to('/CrearDetalle');

    }catch(\Exception $exception){
      return Redirect::back()->with('error', 'El cliente no pudo ser registrado')->withInput();
    }

  }


}
