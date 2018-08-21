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
  $roles= \App\Rol::where('rusrID','!=',"1")->get();
  if(Auth::user()->usrRolID==1){
    return view('auth/register', compact('roles'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarUsuario', 'Auth\RegisterController@registro')->name('register');

//Rutas de Administración de Usuarios
Route::get('/AdministrarUsuarios', function () {
  if(Auth::user()->usrRolID==1){
    $usuarios= \App\User::select('*')->join('rols', 'rols.rusrID', '=', 'users.id')->orderBy('usrCedula','ASC')->get();
    return view('auth/usersAdministration', compact('usuarios'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EliminarUsuario/{id}', 'Auth\UserController@desactivate')->middleware('auth');
Route::get('/ActivarUsuario/{id}', 'Auth\UserController@activate')->middleware('auth');
