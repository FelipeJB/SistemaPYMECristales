<?php

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
Route::get('/EditarPunto/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $punto= \App\PuntoVenta::where('pvID','=',$id)->first();
    $pieces = explode(" ", $punto->pvDireccion,2);
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
    return view('puntosVenta/puntoVentaEdit', compact('punto', 'direccion1','direccion2','direccion3','direccion4', 'remaining'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarPunto', 'Admin\PuntoVentaController@edit')->middleware('auth');
Route::get('/EliminarPunto/{id}', 'Admin\PuntoVentaController@desactivate')->middleware('auth');
Route::get('/ActivarPunto/{id}', 'Admin\PuntoVentaController@activate')->middleware('auth');

//Rutas de Administración de Productos: Diseños
Route::get('/CrearDiseno', function () {
  if(Auth::user()->usrRolID==1){
    return view('productos/registroDiseno');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearDiseno', 'Admin\DisenoController@create')->middleware('auth');
Route::get('/AdministrarDisenos', function () {
  if(Auth::user()->usrRolID==1){
    $disenos= \App\Diseno::orderBy('dsnCodigo', 'ASC')->get();
    return view('productos/disenoAdministration', compact('disenos'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarDiseno/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $diseno= \App\Diseno::where('dsnID','=',$id)->first();
    return view('productos/disenoEdit', compact('diseno'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarDiseno', 'Admin\DisenoController@edit')->middleware('auth');
Route::get('/EliminarDiseno/{id}', 'Admin\DisenoController@desactivate')->middleware('auth');
Route::get('/ActivarDiseno/{id}', 'Admin\DisenoController@activate')->middleware('auth');

//Rutas de Administración de Productos: Colores
Route::get('/CrearColor', function () {
  if(Auth::user()->usrRolID==1){
    return view('productos/registroColor');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearColor', 'Admin\ColorController@create')->middleware('auth');
Route::get('/AdministrarColores', function () {
  if(Auth::user()->usrRolID==1){
    $colores= \App\Color::orderBy('clrCodigo', 'ASC')->get();
    return view('productos/colorAdministration', compact('colores'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarColor/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $color= \App\Color::where('clrID','=',$id)->first();
    return view('productos/colorEdit', compact('color'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarColor', 'Admin\ColorController@edit')->middleware('auth');
Route::get('/EliminarColor/{id}', 'Admin\ColorController@desactivate')->middleware('auth');
Route::get('/ActivarColor/{id}', 'Admin\ColorController@activate')->middleware('auth');

//Rutas de Administración de Productos: Milimetrajes
Route::get('/CrearMilimetraje', function () {
  if(Auth::user()->usrRolID==1){
    return view('productos/registroMilimetraje');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearMilimetraje', 'Admin\MilimetrajeController@create')->middleware('auth');
Route::get('/AdministrarMilimetrajes', function () {
  if(Auth::user()->usrRolID==1){
    $milimetrajes= \App\Milimetraje::orderBy('mlmNumero', 'ASC')->get();
    return view('productos/milimetrajeAdministration', compact('milimetrajes'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarMilimetraje/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $milimetraje= \App\Milimetraje::where('mlmID','=',$id)->first();
    return view('productos/milimetrajeEdit', compact('milimetraje'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarMilimetraje', 'Admin\MilimetrajeController@edit')->middleware('auth');
Route::get('/EliminarMilimetraje/{id}', 'Admin\MilimetrajeController@desactivate')->middleware('auth');
Route::get('/ActivarMilimetraje/{id}', 'Admin\MilimetrajeController@activate')->middleware('auth');
