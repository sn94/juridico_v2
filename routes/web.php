<?php
 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
//use Illuminate\Routing\Route;
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
 

/***
 * MODULO ADMINISTRADORES
 * 
 */
Route::get('signin/p', "ProveedorController@sign_in");
Route::post('signin/p', "ProveedorController@sign_in");
///cerrar sesion
Route::get('signout/p', "ProveedorController@sign_out");
Route::get('/p', "ProveedorController@usuarios");
//Usuarios proveedores
Route::get('p/usuarios', "ProveedorController@usuarios");
//NUEVO PROVIDER****************************
Route::get('p/nuevo-provider', "ProveedorController@cargar");
Route::post('p/nuevo-provider', "ProveedorController@cargar");
//ACTUALIZAR DATOS PROVIDER****************************
Route::get('p/provider/edit/{id}', "ProveedorController@cargar");
Route::post('p/provider/edit/{id}', "ProveedorController@cargar");
//Existe usuario provider
Route::get('p/existe-provider/{nick}/{operacion}', "ProveedorController@nick_existe");
//borrar provider
Route::get('p/provider/del/{id}', "ProveedorController@borrar");
/*******CLIENTE*********** */
//Lista de cliente
Route::get('p/clientes', "SuscriptoresController@clientes");   
Route::get('p/solicitantes', "SuscriptoresController@solicitantes");   
// Nuevo cliente
Route::get('/p/nuevo-suscriptor', "SuscriptoresController@nuevo");    
Route::post('/p/nuevo-suscriptor', "SuscriptoresController@nuevo"); 
//Actualizar datos suscriptor
Route::get('p/suscripcion/edit/{id}', "SuscriptoresController@editar");    
Route::post('p/suscripcion/edit', "SuscriptoresController@editar"); 
 
//Creacion Secuencial de cliente
Route::post('paso1_suscriptor', "SuscriptoresController@paso1_suscriptor");
Route::get('/p/paso2_crearbd/{cliid}', "SuscriptoresController@paso2_crearbd");//manual
Route::get('/p/paso3_creartablas/{cliid}', "SuscriptoresController@paso3_creartablas");//manual
Route::get('p/paso4_gen_credenciales/{cliid}', "SuscriptoresController@paso4_gen_credenciales");//auto
//Deshabilitar habilitar cliente
Route::get('/p/suscriptor/{altabaja}/{idcli}', "SuscriptoresController@actualizar_estado_cliente");  
//Borrar suscriptor
Route::get('/p/suscriptor/del/{idcli}', "SuscriptoresController@borrar");  
 
/**************TIPOS DE PLAN ********** */
Route::get('/p/planes-servicio', "PlanServicioController@index"); 
Route::get('/p/planes-servicio/nuevo', "PlanServicioController@cargar"); 
Route::post('/p/planes-servicio/nuevo', "PlanServicioController@cargar");
Route::get('/p/planes-servicio/{tipo}/{id}', "PlanServicioController@cargar");
Route::post('/p/planes-servicio/{tipo}', "PlanServicioController@cargar");
Route::get('/p/planes-servicio-d/{id}', "PlanServicioController@borrar");
//uso referencial
Route::get('/listar-planes-servicio', "PlanServicioController@listar");
//Pagos
//*********/
Route::get('p/pagos/{id}', "SuscriptoresController@pagos"); //Listar pagos
Route::get('p/pago/{id}', "SuscriptoresController@pago"); //Registrar pago
Route::post('p/pago', "SuscriptoresController@pago"); //Registrar pago


/***
 * Rutas para suscriptores
 */
Route::get('suscripcion', "SuscriptoresController@solicitar"); 
Route::post('suscripcion', "SuscriptoresController@paso1_suscriptor");
Route::get('usuario-existe/{nick}', "UserController@validar_existencia_usuario"); 





/***
 * **********************
 * **********************
 * **********************
 * MODULO CLIENTE
 * **********************
 * **********************
 * **********************
 *****/
Route::get('/', "WelcomeController@index");//una vez autenticado
Route::get('denegado', "WelcomeController@unauthorized");
Route::get('signin',   'UserController@sign_in');
Route::post('signin',   'UserController@sign_in');
Route::get('signout',   'UserController@sign_out'); 


// C R E A R SESION ABOGADO 
Route::post("session-abogados", "AbogadoController@select_cod_abogado"); 


//Verifica si ya se supero el limite de usuarios
Route::get( 'user-creation-alowed' ,  "UserController@user_creation_is_alowed");
/*
Forms de "Datos personales " que no dependen de niveles de usuario
*/
    /*************************LISTADO*****************/
Route::get("ldemandados", "DatosPersoController@index"); //lista datos personales
Route::get("ldemandados/{argumento}", "DatosPersoController@index"); //lista datos personales
Route::get("lgarantes", "DatosPersoController@index_garantes"); //lista datos codeudor
Route::get("lgarantes/{argumento}", "DatosPersoController@index_garantes"); //lista datos codeudor
Route::get("existe-ci/{ci}", "DatosPersoController@existe"); //existencia de Nro de CI
Route::post("ndemandado", "DatosPersoController@nuevo"); //Agregar datos personales
Route::get("vdemandado/{ci}", "DatosPersoController@view"); //vista datos personales






/**
 * Demandas
 */
/************************C R U D*************** */
Route::get( "demandas-agregar/{ci}", 'DemandaController@nueva_demandan');
//nueva demanda para un Nro CI
Route::get( "demandas-agregar", 'DemandaController@nueva_demandan');
//nueva demanda nuevo demandado
Route::post( "demandas-agregar", 'DemandaController@nueva_demandan');
//nueva demanda nuevo demandado procesamiento


//EDICION DE DATOS DE JUICIO
//EDICION DE DATOS PERSONALES
Route::get( "demandas-editar/{iddeman}", 'DemandaController@editar_demandan')->middleware("adminopera");
Route::get( "demandas-editar/{iddeman}/{tab}", 'DemandaController@editar_demandan')->middleware("adminopera");
Route::post( "demandas-editar", 'DemandaController@editar_demandan');

Route::post("enotifi", "NotifiController@editar");
Route::post("eobser", "ObservaController@editar");
Route::get("edemandado/{idnro}", "DatosPersoController@editar")->middleware("adminopera");
Route::post("edemandado", "DatosPersoController@editar")->middleware("adminopera");


//*****OPERACIONES ABIERTAS A TODOS LOS USUARIOS */
//Recuperacion de passw
Route::get('recovery-password',   'UserController@recovery_password');
Route::get('recovery-password/{token}',   'UserController@recovery_password');
Route::post('recovery-password',   'UserController@recovery_password');
Route::post( "reset-password",  'UserController@reset_password');

Route::get("vnotifi/{iddeman}", "NotifiController@ficha"); //ficha de seguimiento (notificacion) individual
Route::get("dema-noti-venc", "NotifiController@notificaciones_venc");//lista de demandas con notificaciones vencidas y no vencidas
Route::post("dema-noti-venc", "NotifiController@notificaciones_venc");//lista de demandas con notificaciones vencidas y no vencidas
Route::get("proce-noti-venc", "NotifiController@procesar_notifi_venc");//procesar demandas con notificaciones vencidas y no vencidas
Route::post("rep-notificaciones/{tipo}", "NotifiController@reporte");//borrar notificaciones vencidas
Route::get("vobser/{iddeman}", "ObservaController@ficha"); //nueva observacion de demanda
Route::get("demandas-by-ci/{ci}", 'DemandaController@demandas_by_ci');//lista  de demandas por CEDULA
Route::get("demandas-by-id/{idnro}", 'DemandaController@demandas_by_id');//lista  de demandas a traves de IDNRO
Route::get("ficha-demanda/{idnro}/{tab}", "DemandaController@ver_demandan");//ficha de demandas
Route::get("ficha-demanda/{idnro}", "DemandaController@ver_demandan");//ficha de demandas
Route::get("arregloextr-recibo/{idrecibo}", "ArregloExtrajudiController@mostrarRecibo");//recibo de pago extrajudicial
Route::get("arregloextr-recibo/{idrecibo}/{opcion}", "ArregloExtrajudiController@mostrarRecibo");//recibo de pago extrajudicial
Route::post("arregloextr-recibo", "ArregloExtrajudiController@mostrarRecibo");//EDICION DE recibo de pago extrajudicial

Route::post("honorarios", "DemandaController@honorarios");//ficha de demandas
Route::get("ver-recibos/{idarreglo}", "ArregloExtrajudiController@mostrarRecibos");//ficha de demandas
/* ***** ARREGLO EXTRAJUDICIAL  *********/
Route::post('arreglo_extra',   'ArregloExtrajudiController@agregar'); 
/***INTERVENCION CONTRAPARTE**** */
Route::post("contraparte/{idnro}", "DemandaController@contraparte"); 
Route::post("contraparte", "DemandaController@contraparte"); 
/***FILTROS */
Route::get('filtros',   'FilterController@index');
Route::get('filtro-nombre/{id}',   'FilterController@get_name');
Route::get('nfiltro',   'FilterController@cargar');
Route::post('nfiltro',   'FilterController@cargar');
Route::get('efiltro/{tipo}/{id}',   'FilterController@cargar');
Route::post('efiltro/{tipo}',   'FilterController@cargar');
Route::get('filtro/{id}/{tipo}/{givehtml}',   'FilterController@reporte');
Route::get('filtro/{id}/{tipo}',   'FilterController@reporte');
Route::get('filtro/{id}/{tipo}',   'FilterController@reporte');
Route::get('res-filtro/{tipo}',   'FilterController@get_parametros'); //Recursos de datos para crear filtros
Route::get('rel-filtro',   'FilterController@relaciones_filtro'); //Datos de relaciones para crear filtros
Route::get('filtro-aviso-rec/{id}',   'FilterController@aviso_recorte_cols');
Route::get('filtro-orden/{col}/{sentido}',   'FilterController@filtro_orden');
/*************************** */





Route::group(['middleware' => 'superadmin'], function () {

    
    /********
     * ABOGADOS
     * 
     ***********/ 
    Route::get("abogados", "AbogadoController@index"); 
    Route::get("abogados/create", "AbogadoController@cargar"); 
    Route::post("abogados/create", "AbogadoController@cargar"); 
    Route::get("abogados/delete/{id}", "AbogadoController@delete"); 
    Route::get("abogados/edit/{id}", "AbogadoController@cargar"); 
    Route::post("abogados/edit/{id}", "AbogadoController@cargar"); 
    Route::get("abogados/pin-regen/{id}", "AbogadoController@regenerar_pin"); //regenerar pin

} );



/** **  administrador  */
Route::group(['middleware' => 'admin'], function () {




    /**BORRADO */
    Route::get('del-plan-cuenta/{id}',   'PlanCtaGastoController@borrar'); 
    Route::get('dgasto/{id}',   'GastosController@borrar'); //vista completa con grilla
    Route::get('dbank/{id}',   'BancoController@borrar'); 
    Route::get('dmovibank/{id}',   'BancoController@borrar_movimiento'); 
    Route::get("dliquida/{idnro}", "LiquidaController@delete"); 
    Route::get("ddemandado/{ci}", "DatosPersoController@borrar"); //Borrar datos personales
    Route::get( "demandas-borrar/{iddeman}", 'DemandaController@borrar');//Borrar demanda
    Route::get("del-noti-venc", "NotifiController@borrar_noti_vencidas");//borrar notificaciones vencidas
    //Route::get("del-noti-venc", "NotifiController@borrar_noti_vencidas");//borrar notificaciones vencidas
    Route::get("dcuentajudi/{idnro}", "JudicialController@delete"); 
    Route::get('dfiltro/{id}',   'FilterController@borrar');

    
/***TABLAS AUXILIARES */
Route::get('auxiliar',   'AuxiController@index');
Route::get('auxiliar/{tabl}',   'AuxiController@index');
Route::post('nuevoaux',   'AuxiController@agregar');
Route::get('editaux/{tabl}/{idnro}',   'AuxiController@editar');
Route::get('delaux/{tabl}/{idnro}',   'AuxiController@borrar');
Route::post('editaux',   'AuxiController@editar');
Route::get('lauxiliar/{tabl}',   'AuxiController@list');
Route::get('res-aux/{tabl}',   'AuxiController@get');

/**  PARAMETROS** */
Route::get('params',   'ParamController@index');
Route::get('lparams',   'ParamController@listar_odema');
Route::get('nparam',   'ParamController@agregar');
Route::post('nparam',   'ParamController@agregar');
Route::get('nodema',   'ParamController@agregarOdemanda');
Route::post('nodema',   'ParamController@agregarOdemanda');
Route::get('eodema/{id}',   'ParamController@editarOdemanda');
Route::post('eodema',   'ParamController@editarOdemanda');
Route::get('dodema/{id}',   'ParamController@borrar');

 



/***USUARIOS */
Route::get('users',   'UserController@index');
Route::get('new-user',   'UserController@agregar');
Route::post('new-user',   'UserController@agregar');
Route::get('edit-user/{idnro}',   'UserController@editar');
Route::post('edit-user',   'UserController@editar');
Route::get('del-user/{id}',   'UserController@borrar');
 


}  );




//SOLO SUPERVISOR Y OPERADOR
Route::group(['middleware' => ['adminopera'  ]  ], function () {

/**CTA JUDICIAL */
Route::get("ctajudicial/{iddeman}", "JudicialController@index"); //con la grilla
Route::get("ncuentajudi/{iddeman}", "JudicialController@nuevo"); 
Route::post("ncuentajudi/{iddeman}", "JudicialController@nuevo"); 
Route::get("ecuentajudi/{idnro}", "JudicialController@editar"); 
Route::post("ecuentajudi/{idnro}", "JudicialController@editar"); 
Route::get("vcuentajudi/{idnro}", "JudicialController@view"); 
Route::get("lcuentajudi/{idnro}", "JudicialController@listar"); 
Route::get("calcsaldo/{iddeman}/{tipo}", "JudicialController@saldo_C_y_L"); 

/**LIQUIDACION */
Route::get("nliquida/{iddeman}", "LiquidaController@nuevo"); 
Route::post("nliquida", "LiquidaController@nuevo"); 
Route::get("eliquida/{idnro}", "LiquidaController@editar"); 
Route::post("eliquida", "LiquidaController@editar"); 
Route::get("vliquida/{idnro}", "LiquidaController@view"); 
Route::get("lliquida/{iddeman}", "LiquidaController@list"); 
Route::get("liquida/{iddeman}", "LiquidaController@index"); 

Route::get("liquida/{idnro}/{tipo}", "LiquidaController@reporte"); //reporte xls o pdf de liquidacion
Route::get("liquida/{idnro}/{tipo}/{HTML}", "LiquidaController@reporte"); //reporte xls o pdf de liquidacion



/**    *******     BANCOS          ** */
Route::get('bank',   'BancoController@index'); 
Route::get('nbank',   'BancoController@agregar'); 
Route::post('nbank',   'BancoController@agregar'); 
Route::get('ebank/{id}',   'BancoController@editar'); 
Route::post('ebank',   'BancoController@editar'); 
Route::get('emovibank/{id}',   'BancoController@editar_movimiento'); 
Route::post('emovibank',   'BancoController@editar_movimiento'); 
Route::get('vbank/{id}',   'BancoController@ViewCtaBanco'); 
Route::get('lbank',   'BancoController@listar'); 
Route::get('lmovibank/{id}',   'BancoController@listar_movimiento'); //listar movimientos de una cuenta
Route::get('depobank/{id}',   'BancoController@deposito'); 
Route::post('depobank',   'BancoController@deposito'); 
Route::get('extrbank/{id}',   'BancoController@extraccion'); 
Route::post('extrbank',   'BancoController@extraccion'); 
Route::get('bank/{id}/{tipo}',   'BancoController@reporte'); //extracto



/**  GASTOS***** */
Route::get('gastos',   'GastosController@index'); 
Route::get('gasto',   'GastosController@cargar'); //insercion
Route::get('gasto/{tipo}/{id}',   'GastosController@cargar'); //edicion
Route::post('gasto',   'GastosController@cargar'); 
Route::post('gasto/{tipo}',   'GastosController@cargar'); 
Route::get('lgastos',   'GastosController@index'); 
Route::get('grillgastos',   'GastosController@listar'); //solo grilla
Route::post('grillgastos',   'GastosController@listar'); //solo grilla
Route::get('rep-gastos/{tipo}',   'GastosController@reporte'); //solo grilla
Route::post('rep-gastos/{tipo}',   'GastosController@reporte'); //solo grilla
Route::get('filtrar-gastos-codigo/{codigo}',   'GastosController@filtrarPorCodigo'); //solo grilla
Route::get('gast-orden/{col}/{sentido}',   'GastosController@ordenar'); //solo grilla
Route::get('demandas_n_gasto/{ci}',   'GastosController@demandas'); //busqueda de demandas por CEDULA


/**************PLAN DE CUENTAS DE GASTOS */
Route::get('plan-de-cuentas',   'PlanCtaGastoController@index'); 
Route::get('plan-cuenta',   'PlanCtaGastoController@cargar'); 
Route::post('plan-cuenta',   'PlanCtaGastoController@cargar'); 
Route::get('plan-cuenta/{tipo}/{id}',   'PlanCtaGastoController@cargar'); 
Route::post('plan-cuenta/{tipo}',   'PlanCtaGastoController@cargar'); 
Route::get('plan-cuenta-list',   'PlanCtaGastoController@listar'); 
Route::get('plan-cuentas-rep/{tipo}',   'PlanCtaGastoController@reporte'); 




} );// grupo supervisor y operador




//Mensajes
/********************** */
Route::get('messenger/{tipo}',   'MessengerController@index');  
Route::get('messenger',   'MessengerController@index');  
Route::get('nuevo-msg',   'MessengerController@agregar'); 
Route::post('nuevo-msg',   'MessengerController@agregar'); 
Route::get('ver-msg/{id}',   'MessengerController@ver'); 
Route::get('del-msg/{id}',   'MessengerController@borrar'); 
Route::get('list-msg/{TIPO}',   'MessengerController@listar'); 





/**MODULO INFORMES***** */

/********informes arreglos extrajudiciales*************** */
Route::get('informes-arre-extra',   'InformesController@informes_arr_extr');
Route::get('informes-arre-extra/{html}',   'InformesController@informes_arr_extr');
Route::post('informes-arre-extra',   'InformesController@informes_arr_extr');
Route::post('informes-arre-extra/{html}',   'InformesController@informes_arr_extr');
//version resumida
Route::get('informes-arregloextrajudicial',   'InformesController@informes_arreglos_resumen');
Route::get('informes-arregloextrajudicial/{html}',   'InformesController@informes_arreglos_resumen');
Route::post('informes-arregloextrajudicial',   'InformesController@informes_arreglos_resumen');
Route::post('informes-arregloextrajudicial/{html}',   'InformesController@informes_arreglos_resumen');
 
//INFORMES CTA JUDICIAL
Route::get('informes-cuentajudicial',   'InformesController@informes_cuenta_judicial');
Route::get('informes-cuentajudicial/{html}',   'InformesController@informes_cuenta_judicial');
Route::post('informes-cuentajudicial',   'InformesController@informes_cuenta_judicial');
Route::post('informes-cuentajudicial/{html}',   'InformesController@informes_cuenta_judicial');
 
//iNFORMES BANCOS
Route::get('bank-informes',   'BancoController@informes'); 
Route::post('bank-informes',   'BancoController@informes'); 
Route::get('bank-informes/{tipo}',   'BancoController@informes'); 
Route::post('bank-informes/{tipo}',   'BancoController@informes'); 






/*****
 * MODULO RECIBOS FREE  
 * ****
 */
Route::get('recibos-free',   'RecibosFreeController@index'); 
Route::get('recibos-free/freeuser',   'RecibosFreeController@nuevo_freeuser'); 
Route::post('recibos-free/freeuser',   'RecibosFreeController@nuevo_freeuser'); 
Route::get('recibos-free/login-freeuser',   'RecibosFreeController@login_freeuser'); 
Route::post('recibos-free/login-freeuser',   'RecibosFreeController@login_freeuser'); 
Route::get('recibos-free/logout-freeuser',   'RecibosFreeController@logout_freeuser'); 
Route::get('recibos-free/menu-freeuser',   'RecibosFreeController@freeuser_menu'); 
Route::get('recibos-free/nuevo',   'RecibosFreeController@nuevo');  
Route::post('recibos-free/nuevo',   'RecibosFreeController@nuevo'); 
Route::get('recibos-free/print/{idrecibo}',   'RecibosFreeController@print'); 
Route::get('recibos-free/pdf/{idrecibo}',   'RecibosFreeController@recibo_pdf'); 
Route::get('recibos-free/list',   'RecibosFreeController@listar'); 
Route::post('recibos-free/mailto',   'RecibosFreeController@send_email'); 
Route::get('recibos-free/mailto/{idrecibo}',   'RecibosFreeController@send_email'); 


Route::get('test',   'ProduccionController@COMPATIBILIDAD_TELEFONOS');



 
