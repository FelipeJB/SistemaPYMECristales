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

//Rutas de registro
Route::get('/RegistrarUsuario', function () {
  if(Auth::user()->usrRolID==1){
    return view('auth/register');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarUsuario', 'Auth\RegisterController@registro')->name('register');
