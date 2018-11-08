<?php

namespace App\Http\Controllers\Migraciones;

use App\Migracion;
use App\MedidaVidrio;
use App\Orden;
use App\OrdenDetalle;
use App\Cliente;
use App\User;
use App\Sistema;
use App\SistemaDetalle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Excel;

class MigracionController extends Controller
{

  public function create()
  {
    /*Se guardan los datos de la migración dentro de variables desde el formulario*/
    $tipo = Input::get('tipo');

    //Traer clientes y órdenes
    $clientes= Cliente::where("cltMigrado", "=", $tipo)->get();
    $ordenes= Orden::where("ordMigrado", "=", $tipo)->get();



    //validar que haya cosas que migrar si el tipo es 0
    if($tipo == 0){
      if (count($clientes) == 0 && count($ordenes)  == 0){
        return Redirect::back()->with('error', 'No existen registros nuevos que migrar')
        ->withInput();
      }
    }

    //generar documentos
    $this->generateMigrationTerceros($clientes, $ordenes);
    $this->generateMigrationTercerosDirecciones($clientes, $ordenes);
    $this->generateMigrationPedidos($clientes, $ordenes);

    //crear y asignar la migración a los objetos si es migración de tipo 0
    if($tipo == 0){
      date_default_timezone_set('America/Bogota');
      $migracion = new Migracion();
      $migracion->mgcFecha = date("Y-m-d H:i");
      $migracion->save();
      foreach($ordenes as $o){
        $o->ordMigrado = $migracion->mgcID;
        $o->save();
      }
      foreach($clientes as $c){
        $c->cltMigrado = $migracion->mgcID;
        $c->save();
      }
    }

    return Redirect::back()->with('success', 'Archivos de migración exportados exitosamente')
    ->withInput();
  }

  public function generateMigrationTerceros()
  {
    $clientes= Cliente::where("cltMigrado", "=", 0)->get();
    //Aquí se genera el excel de terceros con los clientes y órdenes especificados.
    $customer_array[] = array('TipoDeIdentificacion', 'Terceros_Identificacion', 'Ciudad', 'CódigoTercero',
                              'Primer_Nombre', 'Segundo_Nombre', 'Primer_Apellido', 'Segundo_Apellido',
                              'Terceros_Propiedades', 'Nota', 'Activo', 'Terceros - ClasificaciónUno_Clasificación',
                              'Terceros - ClasificaciónDos_Clasificación', 'Terceros - ClasificaciónTres_Clasificación',
                              'FechaDeCreación', 'Plazo', 'Descripcion', 'TarifaIca', 'Cargo', 'Terceros_1_Identificacion',
                              'ListPrecios', 'Personalizado1', 'Personalizado2', 'Personalizado3', 'Personalizado4', 'Personalizado5',
                              'Personalizado6', 'Personalizado7', 'Personalizado8', 'Personalizado9', 'Personalizado10',
                              'Personalizado11', 'Personalizado12', 'Personalizado13', 'Personalizado14', 'Personalizado15',
                              'ZonaUno', 'ZonaDos', 'Clasificacion_Dian');
    foreach ($clientes as $cliente) {
      //separates name
      $nameArray = array();
      $nameArray = explode(" ", $cliente->cltNombre);
      $primerNombre = $nameArray[0];
      $segundoNombre = '';
      if(sizeof($nameArray) == 1){
        $segundoNombre = '';
      }
      if(sizeof($nameArray) == 2){
        $segundoNombre = $nameArray[1];
      }
      if(sizeof($nameArray) >= 3){
        $i = 1;
        for($i = 1; $i < sizeof($nameArray); $i++){
          $segundoNombre .= $nameArray[$i] . ' ';
        }
      }
      //separates last name
      $lastNameArray = array();
      $lastNameArray = explode(" ", $cliente->cltApellido);
      $primerApellido = $lastNameArray[0];
      $segundoNombre = '';
      if(sizeof($lastNameArray) == 1){
        $segundoApellido = '';
      }
      if(sizeof($lastNameArray) == 2){
        $segundoApellido = $lastNameArray[1];
      }
      if(sizeof($lastNameArray) >= 3){
        $i = 1;
        for($i = 1; $i < sizeof($lastNameArray); $i++){
          $segundoApellido .= $lastNameArray[$i] . ' ';
        }
      }
      if($cliente->cltTipoDocumento == 'NIT'){
        $descripcion = 'Persona Juridica Regimen Simplificado';
      }else{
        $descripcion = 'Persona Natural Regimen Simplificado';
      }
      $vendedor = User::where("id", "=", $cliente->cltUsuarioCreador)->get();
      $customer_array[] = array('TipoDeIdentificacion' => $cliente->cltTipoDocumento, //tipo documento
                                'Terceros_Identificacion' => $cliente->cltCedula, //número cédula
                                'Ciudad' => $cliente->cltCiudad,
                                'CódigoTercero' => '',
                                'Primer_Nombre' => $primerNombre,
                                'Segundo_Nombre' => $segundoNombre,
                                'Primer_Apellido' => $primerApellido,
                                'Segundo_Apellido' => $segundoApellido,
                                'Terceros_Propiedades' => 'Cliente;',
                                'Nota' => '',
                                'Activo' => '-1',
                                'Terceros - ClasificaciónUno_Clasificación' => '',
                                'Terceros - ClasificaciónDos_Clasificación' => '',
                                'Terceros - ClasificaciónTres_Clasificación' => '',
                                'FechaDeCreación' => $cliente->cltFechaCreacion, //fecha creación cliente
                                'Plazo' => '0',
                                'Descripcion' => $descripcion, //personal natural o jurídica
                                'TarifaIca' => $cliente->cltTarifaICA, //ni idea '0'
                                'Cargo' => '',
                                'Terceros_1_Identificacion' => $vendedor->id, //céudla vendedor
                                'ListPrecios' => 'Precio 1', //pendiente preguntar
                                'Personalizado1' => '',
                                'Personalizado2' => '',
                                'Personalizado3' => '',
                                'Personalizado4' => '',
                                'Personalizado5' => '',
                                'Personalizado6' => '',
                                'Personalizado7' => '',
                                'Personalizado8' => '',
                                'Personalizado9' => '',
                                'Personalizado10' => '',
                                'Personalizado11' => '',
                                'Personalizado12' => '',
                                'Personalizado13' => '',
                                'Personalizado14' => '',
                                'Personalizado15' => '',
                                'ZonaUno' => '',
                                'ZonaDos' => '',
                                'Clasificacion_Dian' => 'Normal');
    }
    Excel::create('TERCEROS', function($excel) use ($customer_array){
      $excel->setTitle('TERCEROS');
      $excel->sheet('TERCEROS', function($sheet) use ($customer_array){
        $sheet->fromArray($customer_array, null, 'A1', false, false);
      });
    })->download('xlsx');
  }

  private function generateMigrationTercerosDirecciones($clientes, $ordenes)
  {
    //Aquí se genera el excel de terceros direcciones con los clientes y órdenes especificados.
    $clientes= Cliente::where("cltMigrado", "=", 0)->get();
    //Aquí se genera el excel de terceros con los clientes y órdenes especificados.
    $customer_array[] = array('TipoDeIdentificacion', 'Terceros_Identificacion', 'Ciudad', 'CódigoTercero',
                              'Primer_Nombre', 'Segundo_Nombre', 'Primer_Apellido', 'Segundo_Apellido',
                              'Terceros_Propiedades', 'Nota', 'Activo', 'Terceros - ClasificaciónUno_Clasificación',
                              'Terceros - ClasificaciónDos_Clasificación', 'Terceros - ClasificaciónTres_Clasificación',
                              'FechaDeCreación', 'Plazo', 'Descripcion', 'TarifaIca', 'Cargo', 'Terceros_1_Identificacion',
                              'ListPrecios', 'Personalizado1', 'Personalizado2', 'Personalizado3', 'Personalizado4', 'Personalizado5',
                              'Personalizado6', 'Personalizado7', 'Personalizado8', 'Personalizado9', 'Personalizado10',
                              'Personalizado11', 'Personalizado12', 'Personalizado13', 'Personalizado14', 'Personalizado15',
                              'ZonaUno', 'ZonaDos', 'Clasificacion_Dian');
    foreach ($clientes as $cliente) {
      //separates name
      $nameArray = array();
      $nameArray = explode(" ", $cliente->cltNombre);
      $primerNombre = $nameArray[0];
      $segundoNombre = '';
      if(sizeof($nameArray) == 1){
        $segundoNombre = '';
      }
      if(sizeof($nameArray) == 2){
        $segundoNombre = $nameArray[1];
      }
      if(sizeof($nameArray) >= 3){
        $i = 1;
        for($i = 1; $i < sizeof($nameArray); $i++){
          $segundoNombre .= $nameArray[$i] . ' ';
        }
      }
      //separates last name
      $lastNameArray = array();
      $lastNameArray = explode(" ", $cliente->cltApellido);
      $primerApellido = $lastNameArray[0];
      $segundoNombre = '';
      if(sizeof($lastNameArray) == 1){
        $segundoApellido = '';
      }
      if(sizeof($lastNameArray) == 2){
        $segundoApellido = $lastNameArray[1];
      }
      if(sizeof($lastNameArray) >= 3){
        $i = 1;
        for($i = 1; $i < sizeof($lastNameArray); $i++){
          $segundoApellido .= $lastNameArray[$i] . ' ';
        }
      }
      if($cliente->cltTipoDocumento == 'NIT'){
        $descripcion = 'Persona Juridica Regimen Simplificado';
      }else{
        $descripcion = 'Persona Natural Regimen Simplificado';
      }
      $vendedor = User::where("id", "=", $cliente->cltUsuarioCreador)->get();
      $customer_array[] = array('TipoDeIdentificacion' => $cliente->cltTipoDocumento, //tipo documento
                                'Terceros_Identificacion' => $cliente->cltCedula, //número cédula
                                'Ciudad' => $cliente->cltCiudad,
                                'CódigoTercero' => '',
                                'Primer_Nombre' => $primerNombre,
                                'Segundo_Nombre' => $segundoNombre,
                                'Primer_Apellido' => $primerApellido,
                                'Segundo_Apellido' => $segundoApellido,
                                'Terceros_Propiedades' => 'Cliente;',
                                'Nota' => '',
                                'Activo' => '-1',
                                'Terceros - ClasificaciónUno_Clasificación' => '',
                                'Terceros - ClasificaciónDos_Clasificación' => '',
                                'Terceros - ClasificaciónTres_Clasificación' => '',
                                'FechaDeCreación' => $cliente->cltFechaCreacion, //fecha creación cliente
                                'Plazo' => '0',
                                'Descripcion' => $descripcion, //personal natural o jurídica
                                'TarifaIca' => $cliente->cltTarifaICA, //ni idea '0'
                                'Cargo' => '',
                                'Terceros_1_Identificacion' => $vendedor->id, //céudla vendedor
                                'ListPrecios' => 'Precio 1', //pendiente preguntar
                                'Personalizado1' => '',
                                'Personalizado2' => '',
                                'Personalizado3' => '',
                                'Personalizado4' => '',
                                'Personalizado5' => '',
                                'Personalizado6' => '',
                                'Personalizado7' => '',
                                'Personalizado8' => '',
                                'Personalizado9' => '',
                                'Personalizado10' => '',
                                'Personalizado11' => '',
                                'Personalizado12' => '',
                                'Personalizado13' => '',
                                'Personalizado14' => '',
                                'Personalizado15' => '',
                                'ZonaUno' => '',
                                'ZonaDos' => '',
                                'Dirección' => $cliente->cltDireccion,
                                'Teléfonos' => $cliente->cltCelular1,
                                'Ciudad_Direccion' => $cliente->cltCiudad,
                                'Dir_Principal' => '-1');
    }
    Excel::create('TERCEROS DIRECCIONES', function($excel) use ($customer_array){
      $excel->setTitle('TERCEROS DIRECCIONES');
      $excel->sheet('TERCEROS DIRECCIONES', function($sheet) use ($customer_array){
        $sheet->fromArray($customer_array, null, 'A1', false, false);
      });
    })->download('xlsx');
  }

  private function generateMigrationPedidos()
  {
    //Aquí se genera el excel de pedidos con los clientes y órdenes especificados.
    $ordenes= Orden::where("ordMigrado", "=", $tipo)->get();
    //Aquí se genera el excel de terceros con los clientes y órdenes especificados.
    $customer_array[] = array('Empresa', 'IdCuentaContableDocumento', 'prefijo', 'DocumentoNúmero',
                              'Fecha', 'Terceros_Identificacion', 'NúmDocumentoExterno', 'Terceros_1_Identificacion',
                              'CuentasContables - Asientos_Nota', 'Verificado', 'FormaDePago', 'Clasificación',
                              'Person 1 ancho', 'Person 2 alto', 'Person 3 Cantidad', 'Person 4 perforaciones',
                              'Person 5 Boquetes', 'Person 6 BPB', 'Person 7 Chaflan', 'Person 8 F-entrega', 'Person 9 Diseño',
                              'Personalizado10', 'Personalizado11', 'Personalizado12', 'Personalizado13', 'Personalizado14',
                              'Personalizado15', 'CódigoInventario', 'Nombre', 'Cantidad', 'UnidadDeMedida',
                              'MontoMonetarioUnitario', 'Expr1032', 'CCA_M_Inventarios_Nota', 'Vencimiento',
                              'Dcto', 'CostoPromedio', 'Depreciacion', 'Terceros_2_Identificacion',
                              'FactorConversiónMovimientoABodega', 'FactorConversiónMovimientoAInventario', 'Anulado');

    foreach ($ordenes as $orden) {
      $cliente = Cliente::where("cltID", "=", $orden->ordClienteID)->get();
      $detalles = OrdenDetalle::where("orddOrdenID", "=", $orden->ordID)->get();
      $vendedor = User::where("id", "=", $orden->ordVendedorID)->get();

      foreach ($detalles as $detalle) {
        //primera línea de sistema (orddSistemaID)
        $sistema = Sistema::where("stmID", "=", $detalle->orddSistemaID)->get();
        $customer_array[] = array('Empresa' => 'CRISTALES TEMPLADOS LA TORRE SAS',
                                  'IdCuentaContableDocumento' => 'COT',
                                  'prefijo' => '',
                                  'DocumentoNúmero' => '',
                                  'Fecha' => $orden->ordFecha,
                                  'Terceros_Identificacion' => $cliente->cltID,
                                  'NúmDocumentoExterno' => '',
                                  'Terceros_1_Identificacion' => $vendedor->id,
                                  'CuentasContables - Asientos_Nota' => 'COTIZACIÓN',
                                  'Verificado' => '0',
                                  'FormaDePago' => 'Credito',
                                  'Clasificación' => '',
                                  'Person 1 ancho' => '',
                                  'Person 2 alto' => '',
                                  'Person 3 Cantidad' => '1',
                                  'Person 4 perforaciones' => '',
                                  'Person 5 Boquetes' => '',
                                  'Person 6 BPB' => '',
                                  'Person 7 Chaflan' => '',
                                  'Person 8 F-entrega' => '',
                                  'Person 9 Diseño' => '',
                                  'Personalizado10' => '',
                                  'Personalizado11' => '',
                                  'Personalizado12' => '',
                                  'Personalizado13' => '',
                                  'Personalizado14' => '',
                                  'Personalizado15' => '',
                                  'CódigoInventario',
                                  'Nombre' => 'Principal',
                                  'Cantidad',
                                  'UnidadDeMedida',
                                  'MontoMonetarioUnitario',
                                  'Expr1032' => '0.19',
                                  'CCA_M_Inventarios_Nota',
                                  'Vencimiento',
                                  'Dcto',
                                  'CostoPromedio' => '0',
                                  'Depreciacion' => '',
                                  'Terceros_2_Identificacion' => '',
                                  'FactorConversiónMovimientoABodega' => '1',
                                  'FactorConversiónMovimientoAInventario' => '1',
                                  'Anulado' => '0');
        //línea por cada vidrio (orddCantVidrio)
        $vidrios = MedidaVidrio::where("mvdOrddID", "=", $detalle->orddID)->get();
        foreach ($vidrios as $vidrio) {
          $codigoWoVidrio = CodigoWoVidrio::where("cdgMilimID", "=", $detalle->orddMilimID)
                                          ->where("cdgColorID", "=", $detalle->orddColorID)->get();
          $customer_array[] = array('Empresa' => 'CRISTALES TEMPLADOS LA TORRE SAS',
                                    'IdCuentaContableDocumento' => 'COT',
                                    'prefijo' => '',
                                    'DocumentoNúmero' => '',
                                    'Fecha' => $orden->ordFecha,
                                    'Terceros_Identificacion' => $cliente->cltID,
                                    'NúmDocumentoExterno' => '',
                                    'Terceros_1_Identificacion' => $vendedor->id,
                                    'CuentasContables - Asientos_Nota' => 'COTIZACIÓN',
                                    'Verificado' => '0',
                                    'FormaDePago' => 'Credito',
                                    'Clasificación' => '',
                                    'Person 1 ancho' => '',
                                    'Person 2 alto' => '',
                                    'Person 3 Cantidad' => '1',
                                    'Person 4 perforaciones' => '',
                                    'Person 5 Boquetes' => '',
                                    'Person 6 BPB' => '',
                                    'Person 7 Chaflan' => '',
                                    'Person 8 F-entrega' => '',
                                    'Person 9 Diseño' => '',
                                    'Personalizado10' => '',
                                    'Personalizado11' => '',
                                    'Personalizado12' => '',
                                    'Personalizado13' => '',
                                    'Personalizado14' => '',
                                    'Personalizado15' => '',
                                    'CódigoInventario',
                                    'Nombre' => 'Principal',
                                    'Cantidad',
                                    'UnidadDeMedida',
                                    'MontoMonetarioUnitario',
                                    'Expr1032' => '0.19',
                                    'CCA_M_Inventarios_Nota',
                                    'Vencimiento',
                                    'Dcto',
                                    'CostoPromedio' => '0',
                                    'Depreciacion' => '',
                                    'Terceros_2_Identificacion' => '',
                                    'FactorConversiónMovimientoABodega' => '1',
                                    'FactorConversiónMovimientoAInventario' => '1',
                                    'Anulado' => '0');
        }

        //una línea por detalle del sistema (stmdSistemaID)
        $sistemaDetalles = SistemaDetalle::where("stmdSistemaID", "=", $sistema->stmID)->get();
        foreach ($sistemaDetalles as $sistemaDetalle) {
          $customer_array[] = array('Empresa' => 'CRISTALES TEMPLADOS LA TORRE SAS',
                                    'IdCuentaContableDocumento' => 'COT',
                                    'prefijo' => '',
                                    'DocumentoNúmero' => '',
                                    'Fecha' => $orden->ordFecha,
                                    'Terceros_Identificacion' => $cliente->cltID,
                                    'NúmDocumentoExterno' => '',
                                    'Terceros_1_Identificacion' => $vendedor->id,
                                    'CuentasContables - Asientos_Nota' => 'COTIZACIÓN',
                                    'Verificado' => '0',
                                    'FormaDePago' => 'Credito',
                                    'Clasificación' => '',
                                    'Person 1 ancho' => '',
                                    'Person 2 alto' => '',
                                    'Person 3 Cantidad' => '1',
                                    'Person 4 perforaciones' => '',
                                    'Person 5 Boquetes' => '',
                                    'Person 6 BPB' => '',
                                    'Person 7 Chaflan' => '',
                                    'Person 8 F-entrega' => '',
                                    'Person 9 Diseño' => '',
                                    'Personalizado10' => '',
                                    'Personalizado11' => '',
                                    'Personalizado12' => '',
                                    'Personalizado13' => '',
                                    'Personalizado14' => '',
                                    'Personalizado15' => '',
                                    'CódigoInventario',
                                    'Nombre' => 'Principal',
                                    'Cantidad',
                                    'UnidadDeMedida',
                                    'MontoMonetarioUnitario',
                                    'Expr1032' => '0.19',
                                    'CCA_M_Inventarios_Nota',
                                    'Vencimiento',
                                    'Dcto',
                                    'CostoPromedio' => '0',
                                    'Depreciacion' => '',
                                    'Terceros_2_Identificacion' => '',
                                    'FactorConversiónMovimientoABodega' => '1',
                                    'FactorConversiónMovimientoAInventario' => '1',
                                    'Anulado' => '0');
        }
      }
    }
    Excel::create('PEDIDOS', function($excel) use ($customer_array){
      $excel->setTitle('PEDIDOS');
      $excel->sheet('PEDIDOS', function($sheet) use ($customer_array){
        $sheet->fromArray($customer_array, null, 'A1', false, false);
      });
    })->download('xlsx');
  }

}
