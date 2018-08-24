<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->middleware('auth');

//Rutas de Inicio de Sesión
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//Rutas de Registro
Route::get('/RegistrarUsuario', function () {
  if(Auth::user()->usrRolID==1){
    $roles= \App\Rol::where('rusrID','!=',"1")->get();
    return view('auth/register', compact('roles'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarUsuario', 'Auth\RegisterController@registro')->name('register');

//Rutas de Administración de Usuarios
Route::get('/AdministrarUsuarios', function () {
  if(Auth::user()->usrRolID==1){
    $usuarios= \App\User::select('*')->join('rols', 'rols.rusrID', '=', 'users.usrRolID')->orderBy('usrCedula','ASC')->get();
    return view('auth/usersAdministration', compact('usuarios'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarUsuario/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $roles= \App\Rol::where('rusrID','!=',"1")->get();
    $usuario= \App\User::where('id','=',$id)->join('rols', 'rols.rusrID', '=', 'users.usrRolID')->first();
    $pieces = explode(" ", $usuario->usrDireccion,2);
    $direccion1=$pieces[0];
    $remaining=$pieces[1];
    $pieces = explode("#", $remaining,2);
    $direccion2=$pieces[0];
    $remaining=$pieces[1];
    $pieces = explode("-", $remaining,2);
    $direccion3=$pieces[0];
    $remaining=$pieces[1];
    $pieces = explode(".", $remaining,2);
    $direccion4=$pieces[0];
    $remaining=$pieces[1];
    return view('auth/userEdit', compact('usuario', 'roles', 'direccion1','direccion2','direccion3','direccion4', 'remaining'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarUsuario', 'Auth\UserController@edit')->middleware('auth');
Route::get('/EliminarUsuario/{id}', 'Auth\UserController@desactivate')->middleware('auth');
Route::get('/ActivarUsuario/{id}', 'Auth\UserController@activate')->middleware('auth');

//Rutas de Administración de Instaladores
Route::get('/CrearInstalador', function () {
  if(Auth::user()->usrRolID==1){
    return view('instaladores/registroInstalador');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearInstalador', 'Admin\InstaladorController@create')->middleware('auth');
Route::get('/AdministrarInstaladores', function () {
  if(Auth::user()->usrRolID==1){
    $instaladores= \App\Instalador::all()->sortBy('insCedula');
    return view('instaladores/instaladoresAdministration', compact('instaladores'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarInstalador/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $instalador= \App\Instalador::where('insID','=',$id)->first();
    $pieces = explode(" ", $instalador->insDireccion,2);
    $direccion1=$pieces[0];
    $remaining=$pieces[1];
    $pieces = explode("#", $remaining,2);
    $direccion2=$pieces[0];
    $remaining=$pieces[1];
    $pieces = explode("-", $remaining,2);
    $direccion3=$pieces[0];
    $remaining=$pieces[1];
    $pieces = explode(".", $remaining,2);
    $direccion4=$pieces[0];
    $remaining=$pieces[1];
    return view('instaladores/instaladorEdit', compact('instalador', 'direccion1','direccion2','direccion3','direccion4', 'remaining'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarInstalador', 'Admin\InstaladorController@edit')->middleware('auth');
Route::get('/EliminarInstalador/{id}', 'Admin\InstaladorController@desactivate')->middleware('auth');
Route::get('/ActivarInstalador/{id}', 'Admin\InstaladorController@activate')->middleware('auth');

//Rutas de Administración de Puntos de Venta
Route::get('/CrearPunto', function () {
  if(Auth::user()->usrRolID==1){
    return view('puntosVenta/registroPuntoVenta');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearPunto', 'Admin\PuntoVentaController@create')->middleware('auth');
Route::get('/AdministrarPuntos', function () {
  if(Auth::user()->usrRolID==1){
    $puntos= \App\PuntoVenta::orderBy('pvNombre', 'ASC')->get();
    return view('puntosVenta/puntoVentaAdministration', compact('puntos'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EliminarPunto/{id}', 'Admin\PuntoVentaController@desactivate')->middleware('auth');
Route::get('/ActivarPunto/{id}', 'Admin\PuntoVentaController@activate')->middleware('auth');
