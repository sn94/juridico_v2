<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Demandados;
use App\Observacion;

class ObservaController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   


    
 
  /**
   * fICHA DE OBSERVACION
   */


  public function ficha(  $idnro){
    $data= Demanda::find( $idnro);
    $demanObj=  Demandados::where("CI", $data->CI)->first(); 
    return view("observaciones.ficha", ['ficha'=>   $data, 'idnro'=>$idnro, 'ci'=> $demanObj->CI , 'nombre'=>  $demanObj->TITULAR] );
}

 
  
/**Nuevos datos de observacion */

public function agregar( Request $request, $iddeman= 0){
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos
            
        if( $iddeman==0)  $iddeman=  $request->input("IDNRO"); //ID de demanda
        //Quitar el campo _token
        $Params=  $request->input(); 

        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 
         //insert to DB 
        $r= DB::table('obs_demanda')->insert(  $Newparams  );
        //obtener nombre de demandado a partir de idnro 
       if( $r){
            $reg= Demanda::find( $iddeman);
            if( is_null($reg) ){ 
                echo json_encode( array('error'=>  "Código Inválido" ));
       
            }else{
                $ci= $reg->CI;
                $demanObj=  Demandados::where("CI", $ci)->first();
                $nom= $demanObj->TITULAR;
                echo json_encode( array( 'ci'=> $ci, 'nombre'=> $nom ) );
                //return view('observaciones.msg_agregado', [  'iddeman'=>$iddeman ]     ); 
            }/** */
       }else{
        echo json_encode( array('error'=>  "Un problema en el servidor impidió guardar los datos"  ));
        }
       
    }
    else
    {
        $demandao= new Demanda(); 
        $reg= $demandao->find( $iddeman);   
        if( is_null($reg) ){
            echo "Código Inválido";
        }else{
            $ci= $reg->CI;
            $demanObj= new Demandados(); 
            $nom= $demanObj->where("CI", $ci)->first()->TITULAR; 
            return view('observaciones.agregar',  [ 'ci'=> $ci, 'nombre'=> $nom, 'iddeman'=>$iddeman ]  ); }
        }/** */

      
}
   
     

  
/**Nuevos datos de observacion */

public function editar( Request $request, $iddeman=0){

    $obsmodel= NULL;
    if( $iddeman==0) $iddeman= $request->input("IDNRO");
    $obsmodel= Observacion::find( $iddeman );

    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos
            
        //Quitar el campo _token
        $Params=  $request->input(); 

        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 
         //update to DB 
        
         $obsmodel->fill( $Newparams );
         if($obsmodel->save())
         echo json_encode( array( 'ok'=>"GUARDADO" )    );
         else
         echo json_encode( array( 'error'=>"ERROR AL GUARDAR" )    ); 
    }
    else
    {
        $demandao= new Demanda(); 
        $reg= $demandao->find( $iddeman);   
        if( is_null($reg) ){
            echo "Código Inválido";
        }else{
            $ci= $reg->CI;
            $demanObj= new Demandados(); 
            $nom= $demanObj->where("CI", $ci)->first()->TITULAR; 
            return view('observaciones.agregar',  [ 'ci'=> $ci, 'nombre'=> $nom, 'iddeman'=>$iddeman, 'ficha'=> $obsmodel ]  ); }
        }/** */

      
}


 



}