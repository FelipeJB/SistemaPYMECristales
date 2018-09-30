<?php

Route::get('/', function () {
    return view('home');
})->middleware('auth');

//Rutas de Inicio de Sesión
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', [ 'as' => 'login', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//Rutas de Registro de Usuarios
Route::get('/RegistrarUsuario', function () {
  if(Auth::user()->usrRolID==1){
    $roles= \App\Rol::where('rusrID','!=',"1")->get();
    return view('auth/register', compact('roles'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarUsuario', 'Auth\RegisterController@registro')->name('register');

//Rutas de Cambio de contraseña
Route::get('/EditarClave', function () {
    return view('auth/passwordEdit');
})->middleware('auth');
Route::post('/EditarClave', 'Auth\UserController@editPassword');

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

//Rutas de Administración de Productos: Sistemas
Route::get('/CrearSistema', function () {
  if(Auth::user()->usrRolID==1){
    return view('productos/registroSistema');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearSistema', 'Admin\SistemaController@create')->middleware('auth');
Route::get('/AdministrarSistemas', function () {
  if(Auth::user()->usrRolID==1){
    $sistemas= \App\Sistema::orderBy('stmDescripcion', 'ASC')->get();
    return view('productos/sistemaAdministration', compact('sistemas'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarSistema/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $sistema= \App\Sistema::where('stmID','=',$id)->first();
    return view('productos/sistemaEdit', compact('sistema'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarSistema', 'Admin\SistemaController@edit')->middleware('auth');
Route::get('/EliminarSistema/{id}', 'Admin\SistemaController@desactivate')->middleware('auth');
Route::get('/ActivarSistema/{id}', 'Admin\SistemaController@activate')->middleware('auth');

//Rutas de Administración de Productos: Sistemas Detalle
Route::get('/CrearElemento/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $sistema= \App\Sistema::where('stmID','=',$id)->first();
    return view('productos/registroComponente', compact('sistema'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearElemento', 'Admin\SistemaDetalleController@create')->middleware('auth');
Route::get('/AdministrarSistemas/Elementos/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $sistema= \App\Sistema::where('stmID','=',$id)->first();
    $componentes= \App\SistemaDetalle::where('stmdSistemaID','=',$id)->orderBy('stmdDescripcion', 'ASC')->get();
    return view('productos/componenteAdministration', compact('sistema','componentes'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarElemento/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $elemento= \App\SistemaDetalle::where('stmdID','=',$id)->first();
    $sistema= \App\Sistema::where('stmID','=',$elemento->stmdSistemaID)->first();
    return view('productos/componenteEdit', compact('sistema', 'elemento'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarElemento', 'Admin\SistemaDetalleController@edit')->middleware('auth');
Route::get('/EliminarElemento/{idSistema}/{id}', 'Admin\SistemaDetalleController@desactivate')->middleware('auth');
Route::get('/ActivarElemento/{idSistema}/{id}', 'Admin\SistemaDetalleController@activate')->middleware('auth');

//Rutas de Administración de Productos: Precio Vidrio
Route::get('/AdministrarPrecios', function () {
  if(Auth::user()->usrRolID==1){
    $precios= DB::table('precio_vidrios')
            ->join('sistemas', 'precio_vidrios.pvdSistemaID', '=', 'sistemas.stmID')
            ->join('milimetrajes', 'precio_vidrios.pvdMilimID', '=', 'milimetrajes.mlmID')
            ->where('sistemas.stmActivo','=','1')
            ->where('milimetrajes.mlmActivo','=','1')->get();
    return view('vidrios/precioAdministration', compact('precios'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarPrecio/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $precio= DB::table('precio_vidrios')
            ->join('sistemas', 'precio_vidrios.pvdSistemaID', '=', 'sistemas.stmID')
            ->join('milimetrajes', 'precio_vidrios.pvdMilimID', '=', 'milimetrajes.mlmID')
            ->where('precio_vidrios.pvdID','=',$id)->first();
    return view('vidrios/precioEdit', compact('precio'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarPrecio', 'Admin\PrecioVidrioController@edit')->middleware('auth');

//Rutas de Administración de Productos: CodigoWO
Route::get('/AdministrarCodigos', function () {
  if(Auth::user()->usrRolID==1){
    $codigos= DB::table('codigo_wo_vidrios')
            ->join('colors', 'codigo_wo_vidrios.cdgColorID', '=', 'colors.clrID')
            ->join('milimetrajes', 'codigo_wo_vidrios.cdgMilimID', '=', 'milimetrajes.mlmID')
            ->where('colors.clrActivo','=','1')
            ->where('milimetrajes.mlmActivo','=','1')->get();
    return view('vidrios/codigoAdministration', compact('codigos'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarCodigo/{id}', function ($id) {
  if(Auth::user()->usrRolID==1){
    $codigo= DB::table('codigo_wo_vidrios')
            ->join('colors', 'codigo_wo_vidrios.cdgColorID', '=', 'colors.clrID')
            ->join('milimetrajes', 'codigo_wo_vidrios.cdgMilimID', '=', 'milimetrajes.mlmID')
            ->where('codigo_wo_vidrios.cdgID','=',$id)->first();
    return view('vidrios/codigoEdit', compact('codigo'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarCodigo', 'Admin\CodigoWOVidrioController@edit')->middleware('auth');

//Rutas de Ventas
Route::get('/RegistrarCliente', function () {
  if(Auth::user()->usrRolID==2){
    return view('ventas/registroCliente');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarCliente', 'Ventas\ClienteController@create')->middleware('auth');
Route::get('/RegistrarVenta', function () {
  if(Auth::user()->usrRolID==2){
    Request::session()->put('detalles', []);
    return view('ventas/registroVenta1');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarVenta', 'Ventas\VentaController@validateClient')->middleware('auth');
Route::get('/CrearDetalle', function () {
  if(Auth::user()->usrRolID==2 && Request::session()->has('cliente')){
    $cliente = Request::session()->get('cliente');
    $sistemas= \App\Sistema::where('stmActivo','=',1)->get();
    $milimetrajes= \App\Milimetraje::where('mlmActivo','=',1)->get();
    $colores= \App\Color::where('clrActivo','=',1)->get();
    $disenos= \App\Diseno::where('dsnActivo','=',1)->get();
    $detalles= [];
    if(Request::session()->has('detalles')){$detalles = Request::session()->get('detalles');}
    return view('ventas/registroVenta2', compact('detalles', 'cliente', 'sistemas', 'milimetrajes', 'colores', 'disenos'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearDetalle', 'Ventas\VentaController@createDetail')->middleware('auth');
Route::get('/ConfirmarDetalles', function () {
  if(Auth::user()->usrRolID==2 && Request::session()->has('cliente') && Request::session()->has('detalles') && count(Request::session()->get('detalles'))>0){
    $cliente = Request::session()->get('cliente');
    $detalles = Request::session()->get('detalles');
    $total = 0;
    $sistemas = $colores = $milimetrajes = $disenos = [];
    foreach($detalles as $d){
      array_push($sistemas, \App\Sistema::where('stmID','=',$d->orddSistemaID)->first());
      array_push($colores, \App\Color::where('clrID','=',$d->orddColorID)->first());
      array_push($milimetrajes, \App\Milimetraje::where('mlmID','=',$d->orddMilimID)->first());
      array_push($disenos, \App\Diseno::where('dsnID','=',$d->orddDisenoID)->first());
      $total = $total + $d->orddTotal;
    }
    return view('ventas/registroVenta3', compact('detalles', 'cliente', 'total', 'sistemas', 'milimetrajes', 'colores', 'disenos'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EliminarDetalle/{id}', 'Ventas\VentaController@deleteDetail')->middleware('auth');
Route::get('/CancelarOrden', 'Ventas\VentaController@cancelOrder')->middleware('auth');
Route::get('/CrearOrden', function () {
  if(Auth::user()->usrRolID==2 && Request::session()->has('cliente') && Request::session()->has('detalles') && count(Request::session()->get('detalles'))>0){
    $cliente = Request::session()->get('cliente');
    $puntos = \App\PuntoVenta::all();
    $formasPago = \App\FormaPago::all();
    $valorTotal = 0;
    $detalles = Request::session()->get('detalles');
    foreach($detalles as $d){
      $valorTotal = $valorTotal + $d->orddTotal;
    }
    $total = 0;
    return view('ventas/registroVenta4', compact('cliente', 'puntos', 'formasPago', 'valorTotal'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/CrearOrden', 'Ventas\VentaController@createOrder')->middleware('auth');
Route::get('/FinalizarVenta/{id}', function ($id) {
  if(Auth::user()->usrRolID==2){
    $venta= \App\Orden::where('ordID','=',$id)->get();
    if(count($venta)>0){
        return view('ventas/registroVenta5', compact('id'));
    }else{
        return Redirect::to('/');
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/ConsultarVenta', function () {
  if(Auth::user()->usrRolID==2){
    return view('ventas/consultaVenta');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/ConsultarVenta', 'Ventas\VentaController@validateOrderNumberConsulta')->middleware('auth');
Route::get('/ConsultarVenta/{id}', function ($id) {
  if(Auth::user()->usrRolID==2){
    $venta = \App\Orden::where('ordID','=',$id)->get();
    if(count($venta)>0){
        $estado = \App\Estado::where('stdID','=',$venta[0]->ordEstadoInstalacionID)->first();
        return view('ventas/estadoVenta', compact('id', 'estado'));
    }else{
        return Redirect::to('/');
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/GenerarInformeVenta', function () {
  if(Auth::user()->usrRolID==2 || Auth::user()->usrRolID==3){
    return view('ventas/generarInforme');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/GenerarInformeVenta', 'Ventas\VentaController@validateOrderNumberInforme')->middleware('auth');
// Route::post('/GenerarInformeVentaPdf/{id}', function () {
//   if(Auth::user()->usrRolID==2 || Auth::user()->usrRolID==3){
//     $ordenes= DB::table('ordens')
//       ->join('clientes', 'ordens.ordClienteID', '=', 'clientes.cltID')
//       ->orderBy('ordens.ordID', 'DESC')->get();
//     return view('ventas/generarInformePdf', compact('ordenes', 'id'));
//   }else{
//     return Redirect::to('/');
//   }
// })->middleware('auth');
Route::get('/GenerarInformeVentaPdf/{id}', 'Ventas\VentaController@createOrderDocument')->middleware('auth');
Route::get('/Ventas', function () {
  if(Auth::user()->usrRolID==2 || Auth::user()->usrRolID==3){
    $ordenes= DB::table('ordens')
      ->join('clientes', 'ordens.ordClienteID', '=', 'clientes.cltID')
      ->orderBy('ordens.ordID', 'DESC')->get();
    return view('ventas/verVentas', compact('ordenes'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/Ventas/{id}', function ($id) {
  if(Auth::user()->usrRolID==2 || Auth::user()->usrRolID==3){
    $orden= \App\Orden::where('ordID','=',$id)->first();
    $detalles = DB::table('orden_detalles')
      ->join('colors', 'orden_detalles.orddColorID', '=', 'colors.clrID')
      ->join('sistemas', 'orden_detalles.orddSistemaID', '=', 'sistemas.stmID')
      ->join('disenos', 'orden_detalles.orddDisenoID', '=', 'disenos.dsnID')
      ->join('milimetrajes', 'orden_detalles.orddMilimID', '=', 'milimetrajes.mlmID')
    ->where("orden_detalles.orddOrdenID", "=", $id)->get();
    if($orden !=null){
      return view('ventas/detalleVenta', compact('orden', 'detalles'));
    }else{
      return Redirect::to('/');
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');

//Rutas de Registro de Garantías
Route::get('/RegistrarGarantia', function () {
  if(Auth::user()->usrRolID == 2){
    return view('garantias/registroGarantia');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarGarantia', 'Garantias\GarantiaController@validateOrderNumber')->middleware('auth');
Route::get('/RegistrarGarantiaForm/{idOrd}', function ($idOrd) {
  if(Auth::user()->usrRolID == 2){
    $orden = \App\Orden::where("ordID", "=", $idOrd)->first();
    return view('garantias/registroGarantiaForm', compact('orden'));
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarGarantiaForm', 'Garantias\GarantiaController@register')->middleware('auth');
Route::get('/ConsultarGarantia', function () {
  if(Auth::user()->usrRolID==2){
    return view('garantias/generarInforme');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/ConsultarGarantia', 'Garantias\GarantiaController@validateOrderNumberInforme')->middleware('auth');
Route::get('/ConsultarGarantia/{id}', 'Garantias\GarantiaController@getWarrantyDocument')->middleware('auth');

//Rutas de Registro de Medidas
Route::get('/RegistrarMedidas', function () {
  if(Auth::user()->usrRolID == 3){
    return view('medidas/registroMedidas');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarMedidas', 'Medidas\MedidaController@validateOrderNumber')->middleware('auth');
Route::get('/RegistrarMedidasForm/{idMed}/{idItem}', function ($idMed, $idItem) {
  if(Auth::user()->usrRolID == 3){
    $orden = \App\Orden::where("ordID", "=", $idMed)->first();
    $numDetalles = \App\OrdenDetalle::where("orddOrdenID", "=", $idMed)->count();
    $detalle = DB::table('orden_detalles')
          ->join('colors', 'orden_detalles.orddColorID', '=', 'colors.clrID')
          ->join('sistemas', 'orden_detalles.orddSistemaID', '=', 'sistemas.stmID')
          ->join('disenos', 'orden_detalles.orddDisenoID', '=', 'disenos.dsnID')
          ->join('milimetrajes', 'orden_detalles.orddMilimID', '=', 'milimetrajes.mlmID')
          ->where("orden_detalles.orddOrdenID", "=", $idMed)->where("orddItem", "=", $idItem)->first();
    $medida = null;
    if($detalle != null){
      $medida = \App\MedidaVidrio::where("mvdOrddID", "=", $detalle->orddID)->first();
    }
    if($medida != null){
      if($idItem<$numDetalles){
        return Redirect::to('/RegistrarMedidasForm/'.$idMed.'/'.($idItem +1));
      }
      else{
        return Redirect::to('/ConfirmarMedidas');
      }
    }
    else{
      if(Request::session()->has('medidas') && Request::session()->has('orden')){
        if($idItem<=$numDetalles){
          return view('medidas/registroMedidasForm', compact('orden', 'detalle'));
        }else{
          return Redirect::to('/ConfirmarMedidas');
        }
      }else{
        return Redirect::to('/RegistrarMedidas');
      }
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/RegistrarMedidasForm', 'Medidas\MedidaController@register')->middleware('auth');
Route::get('/ConfirmarMedidas', function () {
  if(Auth::user()->usrRolID == 3){
    if(Request::session()->has('medidas') && Request::session()->has('orden')){
      $numOrden = Request::session()->get('orden');
      $medidas = Request::session()->get('medidas');
      $registros = \App\MedidaVidrio::where("mvdOrdID", "=", $numOrden)->count();
      $total = \App\OrdenDetalle::where("orddOrdenID", "=", $numOrden)->count();
      $detalles = [];
      if((count($medidas) + ($registros)/2) == $total){
          foreach($medidas as $m){
            $detalle = DB::table('orden_detalles')
                  ->join('colors', 'orden_detalles.orddColorID', '=', 'colors.clrID')
                  ->join('sistemas', 'orden_detalles.orddSistemaID', '=', 'sistemas.stmID')
                  ->join('disenos', 'orden_detalles.orddDisenoID', '=', 'disenos.dsnID')
                  ->join('milimetrajes', 'orden_detalles.orddMilimID', '=', 'milimetrajes.mlmID')
                  ->where("orden_detalles.orddID", "=", $m->idDetalle)->first();
            array_push($detalles, $detalle);
          }
          return view('medidas/confirmacionMedidas', compact('numOrden','medidas', 'detalles'));
      }else{
          return Redirect::back()->with('error','Se deben registrar todas las medidas');
      }
    } else{
      return Redirect::to('/RegistrarMedidas');
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/EditarMedida/{item}', function ($item) {
  if(Auth::user()->usrRolID == 3){
    $medidas= Request::session()->get('medidas');
    if($medidas!=null && $item <count($medidas)){
      $medida = $medidas[$item];
      $detalle = DB::table('orden_detalles')
            ->join('colors', 'orden_detalles.orddColorID', '=', 'colors.clrID')
            ->join('sistemas', 'orden_detalles.orddSistemaID', '=', 'sistemas.stmID')
            ->join('disenos', 'orden_detalles.orddDisenoID', '=', 'disenos.dsnID')
            ->join('milimetrajes', 'orden_detalles.orddMilimID', '=', 'milimetrajes.mlmID')
            ->where("orden_detalles.orddID", "=", $medida->idDetalle)->first();
      return view('medidas/edicionMedidas', compact('medida', 'detalle', 'item'));
    }else{
      return Redirect::back();
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/EditarMedida', 'Medidas\MedidaController@edit')->middleware('auth');
Route::get('/CancelarMedidas', 'Medidas\MedidaController@cancel')->middleware('auth');
Route::get('/CrearMedidas', 'Medidas\MedidaController@confirm')->middleware('auth');
Route::get('/FinalizarMedidas/{id}', function ($id) {
  if(Auth::user()->usrRolID==3){
    $venta= \App\Orden::where('ordID','=',$id)->get();
    if(count($venta)>0 && $venta[0]->ordEstadoInstalacionID >=2){
        return view('medidas/finalizarMedidas', compact('id'));
    }else{
        return Redirect::to('/');
    }
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::get('/GenerarPlanosMedidas', function () {
  if(Auth::user()->usrRolID==3){
    return view('medidas/generarPlanos');
  }else{
    return Redirect::to('/');
  }
})->middleware('auth');
Route::post('/GenerarPlanosMedidas', 'Medidas\MedidaController@validateOrderNumberPlanos')->middleware('auth');
Route::get('/GenerarPlanosMedidas/{id}', 'Medidas\MedidaController@generarPlanos')->middleware('auth');

//Ruta de descarga de informe de venta
//Route::get('pdf', 'VentaController@createOrderDocument');
