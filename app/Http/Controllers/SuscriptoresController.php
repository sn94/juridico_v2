<?php

namespace App\Http\Controllers;

use App\Bancos;
use App\Demanda;
use App\Demandados;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\AuthAlert;
use App\Mail\CredencialesCliente;
use App\ODemanda;
use App\Plan_servicio;
use App\Suscriptores;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;    
use App\Usu_proveedor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SuscriptoresController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  


public function index(){
 
        return view('0provider.suscriptor.index' );
} 



 
 


 






public function clientes(){
    $ls=    Suscriptores::where("APROBADO", "S")->paginate(10);
    if(  request()->ajax() )
     return view("0provider.suscriptor.grilla", ['clientes'=> $ls ]) ;
    else
    return view('0provider.suscriptor.index' , ["clientes"=>  $ls]);
}



public function solicitantes(){
    $ls=    Suscriptores::where("APROBADO", "N")->paginate(10);
    if(  request()->ajax() )
     return view("0provider.suscriptor.grilla_solicitudes", ['clientes'=> $ls ]) ;
    else
    return view('0provider.suscriptor.solicitudes' , ["clientes"=>  $ls]);
}

 

//Preparacion automatica
 public function nuevo_suscriptor(){
     
    if(  request()->isMethod("POST")){ 

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        DB::beginTransaction();
        try{
         $id_cliente= $this->paso1_suscriptor(  true );
         $this->paso2_crearbd( $id_cliente );
         $this->paso3_creartablas($id_cliente, true);
         $this->paso4_gen_credenciales($id_cliente, true);
         DB::commit();

        }catch( Exception $e){ 
              DB::rollBack();  
             }

    }else{ 
        return view('0provider.suscriptor.create' );
    }
   
 }

 


 public function paso1_suscriptor(  $interno = false){
    set_time_limit(0);
    ini_set('memory_limit', '-1');

     $DATOS= request()->input();
       //Registrar cliente
       $suscr= new Suscriptores();
       $suscr->fill(   $DATOS);
       if( $suscr->save() )
      { 
          if( $interno) return $suscr->IDNRO;
          else{
            if( request()->ajax())
            return response()->json( ['idnro'=>   $suscr->IDNRO] ); 
            else 
            return view("0provider.suscriptor.registrado");
          }
         
        }
       else
       {
        if( $interno) return "error";
        else{
            if( request()->ajax())
            return response()->json(['error'=>  "Error en el servidor"] );
            else 
            echo "Ha ocurrido un error inesperado en el Servidor. Estamos trabajando en ello. Disculpe las molestias";
        }
      
  }
 }


 public function paso2_crearbd( $clienteId, $interno= false){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
      //crear bd
      $NombreBD=  "cli_". $clienteId;
      $charset__= "utf8mb4";
      $collation__= "utf8mb4_unicode_ci";

      //conexion admin
      $conexion_admin=  DB::connection("God");
    $exitCode=  $conexion_admin->statement("CREATE DATABASE IF NOT EXISTS $NombreBD CHARACTER SET $charset__  COLLATE $collation__");
    
          //mysql:host=localhost;port=3306;dbname=testdb
      if(  $exitCode ) {
          $usu= Suscriptores::find( $clienteId);
          $usu->DSN=  "mysql:host=localhost;port=3306;dbname=$NombreBD";
          $usu->save();
          if( $interno)  return "ok";
          else
          return response()->json( ['ok'=>"Base de datos creada"]);
        }
      else
      {
        if( $interno)  return "error";
        else
          return response()->json(['error'=>  "Error en el servidor"] );
        }
 }


 public function paso3_creartablas(  $clienteId, $interno= false){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $NombreBD=  "cli_". $clienteId;
    $comandoR= "mysql -h localhost -u  supervisor -p123 $NombreBD < juridico_v2.sql 2>&1";
    $salida= shell_exec( $comandoR );
    if(  $salida==""   ||  is_null($salida))
    {
        if( $interno) return "ok";
        else
        return response()->json(  ['ok'=>"Tablas creadas"] );
    }
    else
    {
        if( $interno) return "error";
        else
        return response()->json(['error'=>  "Error en el servidor"] );
    }
}



public function  paso4_gen_credenciales( $idcliente, $interno= false){
    set_time_limit(0);
    ini_set('memory_limit', '-1');

    //get client's Database name
    
    $suscriptor= Suscriptores::find(  $idcliente); 
    $ClientDB=  "cli_".( $suscriptor->IDNRO);
    $nickgen= ( $suscriptor->IDNRO)."_usuario";
    //Raw password
    $rawpass=   Helper::generar_password();
    $passgen=   Hash::make(  $rawpass );;
    $client_email= $suscriptor->EMAIL;
 
    $configDb = array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' =>  $ClientDB,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
    );
    Config::set('database.connections.mysql', $configDb);
   $conexionSQL = DB::connection('mysql');
   //Crear usuario primero y su passw
   $salida= $conexionSQL->insert('insert into usuarios (nick, pass, tipo, email) values (?, ?, ?, ?)', 
   [ $nickgen, $passgen, 'S', $client_email]); 
   //Enviar email
   try{
    Mail::to([ $client_email]) 
    //->queue(   new AuthAlert(  $usr,  ["Suscriptores-agent"=>$SuscriptoresAgent, "ip"=>$Ip] ) );
   ->send(  new CredencialesCliente(  $nickgen, $rawpass  ) );
  }catch( Exception $e){}

   if(  $salida )
   {
       if( $interno) return "ok";
       else
       return response()->json(  ['ok'=>"Credenciales creadas"] );
    }
   else
  { 
    if( $interno) return "error";
    else
    return response()->json(['error'=>  "Error en el servidor"] );
}

}


 
    
    
    private function obtenerConexion(   $systemid){
     
        $DataBaseName= "cli_".$systemid;
        
        $configDb = array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' =>  $DataBaseName,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'prefix' => '',
        );
        Config::set('database.connections.mysql', $configDb);
       //$conexionSQL = DB::connection('mysql');
       return $systemid;
    }


public function actualizar_estado_cliente( $modo,  $idcliente){
    $susc= Suscriptores::find( $idcliente );
    if(  $modo != "aprobar")
    {
        $susc->HABILITADO=  $modo== "baja" ?  "No"  : "Si"  ;
        if(  $susc->save()  )
        return response()->json( 
             ['ok'=> ($modo=="aprobar" ) ?"Solicitud aprobada" :  (($modo=="baja")?"Cliente deshabilitado": "Cliente Habilitado" )     ] );
        else
        return response()->json(['error'=>  "Error en el servidor"] );
    }
    else 
   { 
       $susc->APROBADO= "S";
        //Ya se ha creado la base de datos para el cliente?
        $this->obtenerConexion( $susc->IDNRO );
        $conexTest=  DB::connection("mysql");
        try{
            $conexTest->select("select curdate()");
            if(  $susc->save()  )
           {
                $this->paso4_gen_credenciales($idcliente);
               
            }
            else
            return response()->json(['error'=>  "Error en el servidor"] );
        }catch(Exception $Ex){
            return response()->json(   ['error'=>"Sin base de datos asociada a esta cuenta"]);
        }
      
    } 

}






public function borrar( $id){
    if(  Suscriptores::find($id)->delete() ) echo json_encode( array('ok'=>  "BORRADO"  ) );
    else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );
 
 }









 
 public function solicitar(){


    //listar planes servicio
    $Plan_servicio= Plan_servicio::get();
     return view("0provider.suscriptor.solicitud", ['planes'=>  $Plan_servicio ]);
 }

}