<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Http\Controllers\Controller;
use App\ODemanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Parametros;
use Illuminate\Http\Client\Request as ClientRequest;

class AuxiController extends Controller
{
    

    private $tablas= array("demandan"=>"DEMANDANTE", "odemanda"=>"ORIGEN DE DEMANDA","localida"=>"LOCALIDAD",
    "juzgado"=>"JUZGADO", "actuaria"=>"ACTUARIA", "juez"=>"JUEZ", "instituc"=>"INSTITUCION",
    "instipo"=>"TIPO DE INSTITUCION","bancos"=> "BANCOS" );

    public function __construct()
    {
      //  parent::__construct();
        date_default_timezone_set("America/Asuncion");
    }
   

    

public function index( $tabl="demandan"){
    $this->obtenerConexion();
    $ls= DB::table( $tabl)->get();
    $ruta_listado= url("lauxiliar/$tabl");
    return view('auxiliares.index' ,
    ["lista"=> $ls, "OPERACION"=>"A", "TABLA"=> $tabl , 
    "OPCS"=> $this->tablas, "OPC_A"=>$tabl,"ruta_listado"=> $ruta_listado  ]);
} 



/**OBTENER REGISTROS A PARTIR DEL NOMBRE DE LA TABLA ****/
 public function get( $tabla ){
    $this->obtenerConexion();
        //pROPORCIONAR RUTAS A LOS RECURSOS 
        $registro= array();
        if( $tabla =="odemanda")
        $registro=  DB::table($tabla)->select( "IDNRO", "NOMBRES as DESCR")->get();
        else
        $registro=  DB::table($tabla)->select( "IDNRO", "DESCR")->get();
        echo json_encode(  $registro);
 }
   

   
public function agregar( Request $request){
    if(  request()->isMethod("POST"))  {//hay datos 
        $this->obtenerConexion();
        //Quitar el campo _token
        $Params=  $request->input(); 
        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"],"TABLA"=> $Params['TABLA'] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 

         DB::beginTransaction();
        try{
             $r= DB::table($Params['TABLA']); 
             $r->insert( $Newparams  );
             echo json_encode( array('ok'=>  "GUARDADO"  ));    
             DB::commit();
       
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else  {   return view('auxiliares.index', ["OPERACION"=>"A", 'TABLA'=> "demandan", 'CAMPO'=> $this->tablas["demandan"] ]);
       }/** */    
}


 

   
public function editar( Request $request, $tabl="", $idnro=""){
    $this->obtenerConexion();
    if(  request()->isMethod("POST"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input(); 
        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] , "TABLA"=> $Params['TABLA']),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 

         DB::beginTransaction();
        try{
             $r= DB::table($Params['TABLA']); 
             $r->where('IDNRO', $Params['IDNRO'])
             ->update( $Newparams  );
             echo json_encode( array('ok'=>  "ACTUALIZADO"  ));    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else  {   
       $ob= DB::table($tabl)->where('IDNRO',$idnro )->first();
        return view('auxiliares.form', ["OPERACION"=>"M", 'TABLA'=> $tabl , "DATO"=>  $ob]   );
       }/** */    
}



public function borrar( $tabl, $idnro){
    $this->obtenerConexion();
    $ob= DB::table($tabl)->where('IDNRO',$idnro , 1)->delete();
   if( $ob ) echo json_encode( array('ok'=>  "BORRADO"  ) );
   else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );

}

public function list( $tabl){
    $this->obtenerConexion();
    $OrderField= (  $tabl == "odemanda")?  "NOMBRES" :  "DESCR";
    $ls= DB::table( $tabl)->orderBy(  $OrderField)->get();
    return view('auxiliares.grilla' , ["lista"=>  $ls, "TABLA"=> $tabl  ]);
}


}