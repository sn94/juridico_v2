<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Http\Controllers\Controller;
use App\Messenger;
use App\ODemanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Parametros;
use App\User;
use Illuminate\Http\Client\Request as ClientRequest;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class MessengerController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   

    

public function index($tipo="R"){
 
    $ls= NULL;
    $id= session("id");

    $tipo_usu= $tipo=="E" ? "DESTINATARIO" : "REMITENTE";
    $tipo_usu2= "mensajes.".( $tipo=="E" ? "REMITENTE" : "DESTINATARIO");
   try{
    $ls=Messenger::addSelect([ "nick" => User::select('nick')
    ->whereColumn('IDNRO', "mensajes.$tipo_usu")  ])
    ->where( $tipo_usu2 ,   $id )
    ->get();

        $url_listado="";
        if( $tipo=="R") $url_listado=url("list-msg/R");
        else $url_listado=url("list-msg/E"); 
        return view('messenger.index',  
        ["lista"=> $ls , "url_listado"=>$url_listado,"tipo"=>$tipo ] );
   }catch(Exception $ex){
    echo $ex;
   }
} 




    
public function agregar( Request $request){
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input();      
        $r= new Messenger(); 
        $r->fill(  $Params  );  
        if($r->save())
             echo json_encode( array('ok'=>  "ENVIADO"  ));    
        else
        echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>") );
        
    }
    else  { 
        //Listar usuarios
        $usuarios= User::where("IDNRO","<>", session("id") )->pluck('NICK', 'IDNRO');//
        return view('messenger.form', ['usuarios'=> $usuarios ] ); 
       }
}
   

    

 

public function borrar( $id){
   if(  Messenger::find($id)->delete() ) echo json_encode( array('IDNRO'=>  $id  ) );
   else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );

}


public function ver( $id ){ 
    $datos=  Messenger::find( $id )  ;
    $remi= $datos->REMITENTE;
    $remi_nick= User::find( $remi)->nick;
    $marcar="N";
    if( session("id")== $datos->DESTINATARIO) { $marcar="S";$datos->LEIDO= "S"; $datos->save();}

    return view("messenger.view", ['dato'=> $datos, 'remitente'=>$remi_nick , 'marcar'=> $marcar]);
     
}



public function listar( Request $request, $tipo="E"){
  //  DB::enableQueryLog();
    //$log = DB::getQueryLog();
    $ls= NULL;
    $id= session("id");

    $tipo_usu= $tipo=="E" ? "DESTINATARIO" : "REMITENTE";
    $tipo_usu2= "mensajes.".( $tipo=="E" ? "REMITENTE" : "DESTINATARIO");
    $ls=Messenger::addSelect([ "nick" => User::select('nick')
    ->whereColumn('IDNRO', "mensajes.$tipo_usu")  ])
    ->where( $tipo_usu2 ,   $id )
    ->orderBy("created_at")
    ->get();
     
    if( $request->ajax())
    return view('messenger.grilla' , ["lista"=>  $ls, 'tipo'=>$tipo, ]);
    else {
        $url_listado=url("list-msg/R");
        return view('messenger.index' , ["lista"=>  $ls, "url_listado"=>$url_listado, 'tipo'=>$tipo ]);
    }
}


//hay mensajes recibidos sin leer
public static function mensajesRecibidosSinLeer(){
try{
    $datos= Messenger::where("DESTINATARIO",  session("id") )->where("LEIDO", "N")->get();
   return  ! is_null(  $datos );
}catch( Exception $ex) {echo $ex;}
}

//Hay mensajes enviados
 public static function mensajesEnviados(){
  try{  return  ! is_null(Messenger::where("REMITENTE",  session("id") )->get() );}
  catch( Exception $ex) {echo $ex;}
 }
 

/***NUMERO de Mensajes sin leer */
 public static function numeroMensajesSinLeer(){
   try{ return  Messenger::where("DESTINATARIO",  session("id") )->where("LEIDO", "N")->count() ;}
   catch( Exception $ex) {echo $ex;}
 }

 /**NUMERO DE ENVIADOS */
 public static function numeroEnviados(){
   try{ return  Messenger::where("REMITENTE",  session("id") )->count() ;}
   catch(Exception $ex) { return 0;}
 }
 /**OBTENER LOS 3 PRIMEROS MENSAJES SIN LEER */
public static function getMensajesRecibidosSinLeer(){
   try{ return  Messenger::where("DESTINATARIO",  session("id") )->where("LEIDO", "N")->take(3)->get() ;}
   catch(Exception $ex) { echo $ex; }
 }



 
 public static function getMensajesEnviados(){
    try{ return  Messenger::where("REMITENTE",  session("id") )->take(3)->get() ;}
    catch(Exception $ex) { echo $ex; }
  }
 

}