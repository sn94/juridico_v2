<?php

namespace App\Http\Controllers;

use App\Arreglo_extrajudicial;
use App\Contraparte;
use App\Demanda;
use App\Demandados;
use App\Honorarios;
use App\Http\Controllers\Controller;
use App\Notificacion;
use App\Observacion;
use Exception;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class DatosPersoController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }

/**
 * AGREGAR
 */
    public function index( Request $request, $argumento=""){
        /*
          select  demandado.*, count(demandas2.CI) as nro from `demandado` inner join `demandas2`
           on `demandas2`.`CI` = `demandado`.`CI` where  demandado.CI LIKE '%p%' or  TITULAR LIKE '%p%' or 
           DOMICILIO LIKE '%p%' OR TELEFONO LIKE '%p%' GROUP by demandas2.IDNRO  limit 20 offset 0
          */
          $argumento=  preg_split("/[\s]+/", $argumento);
          if( sizeof($argumento)) $argumento= implode("%", $argumento);
          //Con paginacion 
          $consulta= "";
          if(  $argumento != ""){
            $consulta= DB::table("demandado") 
            ->selectRaw(" demandado.IDNRO,demandado.CI,demandado.TITULAR,demandado.DOMICILIO, demandado.TELEFONO, (select count(demandas2.IDNRO) from demandas2 where demandas2.DEMANDADO= demandado.IDNRO) as nro")
            ->where("demandado.ABOGADO", session("abogado"))
            ->whereRaw(" demandado.CI LIKE '%$argumento%' or  TITULAR LIKE '%$argumento%'  ")  ;
          }else{
            $consulta= DB::table("demandado") 
            ->where("demandado.ABOGADO", session("abogado"))
            ->selectRaw( "demandado.IDNRO, demandado.CI,demandado.TITULAR,demandado.DOMICILIO, demandado.TELEFONO, (select count(demandas2.IDNRO) from demandas2 where demandas2.DEMANDADO= demandado.IDNRO) as nro");
          }

            $dmds=  $consulta->paginate(20);
            $sqlq= $consulta->toSql(); 
            // echo $sqlq;
            if(  $request->ajax()){
            return view('demandado.list_paginate_ajax', ['lista' => $dmds]  ); 
            }else
            return view('demandado.list_paginate', ['lista' => $dmds]  ); 
           
       
    }




    public function index_garantes( Request $request, $argumento=""){
      /*
        select  demandado.*, count(demandas2.CI) as nro from `demandado` inner join `demandas2`
         on `demandas2`.`CI` = `demandado`.`CI` where  demandado.CI LIKE '%p%' or  TITULAR LIKE '%p%' or 
         DOMICILIO LIKE '%p%' OR TELEFONO LIKE '%p%' GROUP by demandas2.IDNRO  limit 20 offset 0
        */
        $argumento=  preg_split("/[\s]+/", $argumento);
        if( sizeof($argumento)) $argumento= implode("%", $argumento);
        //Con paginacion 
        $consulta= "";
        if(  $argumento != ""){
          $consulta= DB::table("demandado") 
          ->selectRaw(" demandado.IDNRO,demandado.CI_GARANTE,demandado.GARANTE,demandado.DOM_GARANT, demandado.TEL_GARANT")
          ->where("demandado.ABOGADO",  session("abogado") )
          ->whereRaw(" (demandado.CI_GARANTE LIKE '%$argumento%' or  demandado.GARANTE LIKE '%$argumento%')  ") 
          ->whereRaw("( (demandado.CI_GARANTE is NOT null AND demandado.CI_GARANTE <> '')   or  (demandado.GARANTE is NOT null  AND demandado.GARANTE <> '') ) ")  ;
        }else{
          $consulta= DB::table("demandado") 
          ->where("demandado.ABOGADO",  session("abogado") )
          ->selectRaw( "demandado.IDNRO, demandado.CI_GARANTE,demandado.GARANTE,demandado.DOM_GARANT, demandado.TEL_GARANT")
          ->whereRaw(" ((demandado.CI_GARANTE is NOT null AND demandado.CI_GARANTE <> '')   or  (demandado.GARANTE is NOT null  AND demandado.GARANTE <> '') ) ") ;
        }
       $dmds=  $consulta->paginate(20);
      $sqlq= $consulta->toSql(); 
      
     //echo $sqlq;
      if(  $request->ajax()){
      return view('demandado.garante.list_paginate_ajax', ['lista' => $dmds]  ); 
      }else
      return view('demandado.garante.list_paginate', ['lista' => $dmds]  ); 
  }


 
/**  FICHA DE DATOS PERSONALES  **/
    public function view(  $ci){
        $data= DB::table("demandado")->where('CI', $ci)->first();
        return view("demandado.view", ['ficha'=>   $data] );
    }

  /**VERIFICAR SI EXISTE UN CI */
  public function existe(  $ci){
      $data= DB::table("demandado")->where('CI', $ci)->first();
      $ex= is_null($data) ? "n": "s";
      echo json_encode( array("existe"=>  $ex) );
  }


  /*
    NUEVA DEMANDADO
    */
    public function nuevo(Request $request){
        if(  $request->isMethod("POST") )  {
            //Quitar el campo _token
            $Params=  $request->input(); 
            $Params['ABOGADO']= session("abogado");
            
            //***********TRANSACCION SQL****** */
            DB::beginTransaction();
            try {
              //insert to DB ELOQUENT VERSION
              $modelo= new Demandados();  $modelo->fill( $Params );  $modelo->save();
              //$ultimoIdGen=  $modelo->IDNRO; 
              /**generar registro en demanda, en notifi y en observacion */
              
              $deman= new Demanda(); $deman->DEMANDADO= $modelo->IDNRO;  $deman->CI= $modelo->CI; $deman->ABOGADO=  session("abogado"); $deman->save();

              $noti= new Notificacion();   $noti->IDNRO= $deman->IDNRO; $noti->CI= $deman->CI; $noti->ABOGADO=  session("abogado"); $noti->save();
              $obs= new Observacion(); $obs->IDNRO= $deman->IDNRO;    $obs->CI= $deman->CI; $obs->ABOGADO=  session("abogado"); $obs->save();
              $contra= new Contraparte(); $contra->IDNRO= $deman->IDNRO;  $contra->ABOGADO_=  session("abogado"); $contra->save();
              $obarre= new Arreglo_extrajudicial();  $obarre->IDNRO= $deman->IDNRO;  $obarre->ABOGADO= session("abogado"); $obarre->save();
               $obhonorario= new Honorarios(); $obhonorario->IDNRO= $deman->IDNRO; $obhonorario->ABOGADO=  session("abogado"); $obhonorario->save();
              
               DB::commit();
              echo json_encode( 
                array(  'IDNRO'=> $modelo->IDNRO,  'ci'=> $modelo->CI,     'nombre'=> $modelo->TITULAR,   "id_demanda"=> $deman->IDNRO)   );
            } catch (\Exception $e) {
                DB::rollback();
                echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
            }  
        }
        else  return view('demandado.agregar'); 
    }

 /**
  * EDITAR
  */
  public function editar(Request $request, $idnro=0){//idnro es CEDULA
    
    //Demandados::find( $idnro );
    if( $request->isMethod("POST"))  {
        //Quitar el campo _token
        $Params=  $request->input();  
        //update to DB ELOQUENT VERSION 
        $idnro= $request->input("IDNRO");
        $modelo= Demandados::find( $idnro);
        $modelo->fill( $Params );
        if($modelo->save()){
          echo json_encode(array(  'ci'=> $idnro, 'nombre'=> $modelo->TITULAR  ));
        }else{
          echo json_encode(array(  'error'=> 'Un problema en el servidor impidió guardar los datos. Contacte con su desarrollador.' )); 
        } 
    }
    else{
      $modelo= Demandados::find( $idnro);
      $localidades= DB::table("localida")->get();// Localidad
       return view('demandas.demandado_form', 
        ['ci'=> $modelo->CI,   'ficha0'=> $modelo, 'localidades'=>$localidades, 'OPERACION'=>"M" ] ); 
      }
}

  


public function borrar($ci){ //En realidad se recibiria el IDNRO

  if(session("tipo")=="S" || session("tipo")=="SA"){
    $demandado= Demandados::find( $ci);
    $demanda= Demanda::where("CI", $demandado->CI)->first();
    if( is_null($demanda)){  //Se puede borrar
       Demandados::where("CI", $ci)->first()->delete();
       echo json_encode( array( 'ci'=> $ci) );
     }else{
       echo json_encode( array( 'error'=> "Los datos de esta persona no pueden borrarse. Existen datos judiciales ") );
     } 
  }else{
    echo json_encode( array( 'error'=>"Acción no autorizada. Consulte con el administrador"));
  }
}/** end  */

}