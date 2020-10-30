<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Demandados;
use App\Helpers\Helper;
use App\Notificacion;
use App\pdf_gen\PDF;

class NotifiController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   


 
  /**
   * fICHA DE SEGUIMIENTO
   */


  public function ficha(  $idnro){
    $data= Notificacion::find( $idnro);
    $demanObj=  Demandados::where("CI", $data->CI)->first(); 
    return view("notificaciones.ficha", ['ficha'=>   $data, 'idnro'=>$idnro, 'ci'=> $demanObj->CI , 'nombre'=>  $demanObj->TITULAR] );
}




/**Nuevos datos de seguimiento */

public function agregar( Request $request, $iddeman=0){
    
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos
            
        if( $iddeman == 0)  $iddeman= $request->input("IDNRO"); 
        //Quitar el campo _token
        $Params=  $request->input(); 

        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 
         //insert to DB 
        $r= DB::table('notificaciones')->insert(  $Newparams  );
        //obtener nombre de demandado a partir de idnro 
        if( $r){
            $reg= Demanda::find( $iddeman);
            if( is_null($reg) ){ 
                echo json_encode( array('error'=>  "Código Inválido"  ));
            }else{
                $ci= $reg->CI;
                $demanObj=  Demandados::where("CI", $ci)->first();
                $nom= $demanObj->TITULAR; 
                echo json_encode( array('ci'=> $ci, 'nombre'=> $nom  ));
               // return view('notificaciones.msg_agregado', [ 'ci'=> $ci, 'nombre'=> $nom, 'iddeman'=>$iddeman ]     ); 
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
            return view('notificaciones.agregar',  [ 'ci'=> $ci, 'nombre'=> $nom, 'iddeman'=>$iddeman ]  ); }
        }/** */

      
}


/**
 * ACTUALIZAR
 * 
 */

 
public function editar( Request $request, $iddeman=0){
    $notimodel= NULL;
    if( $iddeman == 0) $iddeman= $request->input("IDNRO");
    $notimodel= Notificacion::find( $iddeman);
    
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos
            
        //Quitar el campo _token
        $Params=  $request->input(); 

        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 
         //update to DB 
         $notimodel->fill( $Newparams);
         $notimodel->save(); 

        //obtener nombre de demandado a partir de idnro 
       
        $reg= Demanda::find( $iddeman);
        if( is_null($reg) ){
            echo "Código Inválido";
        }else{
            $ci= $reg->CI;
            $demanObj=  Demandados::where("CI", $ci)->first();
            $nom= $demanObj->TITULAR;
            echo json_encode( array( 'ci'=> $ci, 'nombre'=> $nom, 'iddeman'=>$iddeman )    ); 
        }/** */
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
            return view('notificaciones.editar',  [ 'ci'=> $ci, 'nombre'=> $nom, 'iddeman'=>$iddeman, 'ficha'=>$notimodel ]  ); }
        }/** */

      
}
    //*************************************************** */
    /***NOtificaciones vencidas*** */


    private function fecha_sgte( $fecha){  
       //convertir a segundos
        //strtotime recibe la fecha en formato Y-m-d
        $date1 = strtotime( $fecha  ); //fecha en seg 
        $fechasgte =  strtotime("+1 day", $date1);//fecha de notificacion mas 1 dia
        return $fechasgte;
    }

    private function is_fecha_vencimiento( $fech, $dias=""){
        /****DIAS PARA EL VENCIMIENTO */
        $dias_param=DB::table("parametros")->get("DIASVTO")->first()->DIASVTO;
        $diavto= $dias!="" ? intval($dias) : intval( $dias_param  );

        $vencido_datos= array("vencido"=>false);
         /**VERIFICACION FECHA VALIDA */
        $fecha_demanda = date_create_from_format('j/m/Y',  trim( $fech ));  
        if( $fecha_demanda ){//Si la fecha convertida es valida  
            $i=1;
            while($i<= $diavto){ 
               $fechasgte= $this->fecha_sgte( $fech);
                //FECHA DE NOTIFICACION ES ANTERIOR O IGUAL A HOY, Y NO ES DOMINGO  NI SABADO 
               if( $fechasgte <= time() &&  date("N", $fechasgte)!=1 && date("N",$fechasgte)!=7  ){ 
                  
                 $vencido_datos= array("vencido"=> true, "fechavenci"=>  date("d-m-Y", $fechasgte) ); 
                $i= $diavto;//salir
               }//END IF
                 $i++; 
            }//END WHILE 
        }//END IF
        return $vencido_datos;
    }

    private function get_fecha_vencimiento( $fech, $dias=""){
        /****DIAS PARA EL VENCIMIENTO */
        $dias_param=DB::table("parametros")->get("DIASVTO")->first()->DIASVTO;
        $diavto= $dias!="" ? intval($dias) : intval( $dias_param  );

        $vencido_datos= "";
         /**VERIFICACION FECHA VALIDA */
        $fecha_demanda = date_create_from_format('Y-m-j',  trim( $fech ));  
        if( $fecha_demanda ){//Si la fecha convertida es valida  
            $i=1;
            $fechasgte= "";
            $fechasgt_str= $fech;
            while($i<= $diavto){  
               $fechasgte= $this->fecha_sgte(   $fechasgt_str); 
               $fechasgt_str=  date("Y-m-j", $fechasgte);
              
               if(  $i==$diavto ){
                        // NO ES DOMINGO  NI SABADO y ya termino el plazo de x dias
                        if( date("N", $fechasgte)!=1 && date("N",$fechasgte)!=7){ 
                            $vencido_datos=   date("Y-m-j", $fechasgte) ;  
                            $i= $diavto+1;
                        } 
               }else{
                $i++;
               }  
            }//END WHILE 
        }//END IF
        return $vencido_datos;
    }



    /*
    VERIFICA demandas con notificaciones vencidas Y NO VENCIDAS
    */ 



private function fecha_valida($fecha){
    
   return ($fecha !="" &&  $fecha !="0000-00-00");
}



/*
select `notificaciones`.`IDNRO`, `NOTIFI_1`, DATEDIFF( NOTIFI_1, NOW()) AS NOTIFI1_V, `ADJ_AI`,
 `INTIMACI_1`, DATEDIFF( INTIMACI_1, NOW()) AS INTIMACI1_V,
  `INTIMACI_2`, DATEDIFF( INTIMACI_2, NOW()) AS INTIMACI2_V,
   `NOTIFI1_AI_TIT`, DATEDIFF( NOTIFI1_AI_TIT, NOW()) AS NOTIFI1_AI_TIT_V,
    `NOTIFI1_AI_GAR`, DATEDIFF( NOTIFI1_AI_GAR, NOW()) AS NOTIFI1_AI_GAR_V, 
    `NOTIFI2_AI_TIT`, DATEDIFF( NOTIFI2_AI_TIT, NOW()) AS NOTIFI2_AI_TIT_V,
     `NOTIFI2_AI_GAR`, DATEDIFF( NOTIFI2_AI_GAR, NOW()) AS NOTIFI2_AI_GAR_V, `CITACION`, 
     `NOTIFI_2`, DATEDIFF( NOTIFI_2, NOW()) AS NOTIFI2_V, 
     `NOTIFI_3`, DATEDIFF( NOTIFI_3, NOW()) AS NOTIFI3_V, 
     `NOTIFI_4`, DATEDIFF( NOTIFI_4, NOW()) AS NOTIFI4_V, 
     `NOTIFI_5`, DATEDIFF( NOTIFI_5, NOW()) AS NOTIFI5_V, `ADJ_SD`, `ADJ_APROBA`, `ADJ_OFICIO`, `SALDO`,
      `ADJ_LIQUI` from `notificaciones` inner join `demandas2` on `demandas2`.`IDNRO` = `notificaciones`.`IDNRO` 
      where (`ARREGLO_EX` = 'N' or `ARREGLO_EX` = '') and (`EMBARGO_N` is null or `EMBARGO_N` = '0') and 
      (`SD_FINIQUI` is null or `SD_FINIQUI` = '0') and `demandas2`.`SALDO` > 0 and (`NOTIFI_5` is null or `NOTIFI_5` = '0000-00-00')
       and (select count(*) from `mov_cta_judicial` inner join `cuenta_judicial` on 
       `cuenta_judicial`.`IDNRO` = `mov_cta_judicial`.`CTA_JUDICIAL` where `cuenta_judicial`.`ID_DEMA` = `demandas2`.`IDNRO` limit 1) = 0
*/

    //GRABAR NOTIFICACIONES
    public function procesar_notifi_venc(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        //DB::enableQueryLog();
           //Filtrar 
           $SEGUI_OBJ= Notificacion::
           join("demandas2", "demandas2.IDNRO","=","notificaciones.IDNRO")
           ->where(  function($query) {
               $query->where('ARREGLO_EX', 'N')
                     ->orWhere('ARREGLO_EX', "");
           }  )                       //Sin arreglo extrajudicial
           ->where(function($query) {
            $query->whereNull('EMBARGO_N')
                    ->orWhere('EMBARGO_N','0')    ;
            })
            ->where(function($query) {
                $query->whereNull('SD_FINIQUI')
                        ->orWhere('SD_FINIQUI','0')    ;
                })
           ->where('demandas2.SALDO', '>', 0)
           ->where(function($query) {
            $query->whereNull('NOTIFI_5')
                    ->orWhere('NOTIFI_5','0000-00-00')    ;
            })
            ->where("FLAG","=", "N")
            ->where(function ($query) {
                $query->select(DB::raw("count(*)"))
                    ->from('mov_cta_judicial')
                    ->join("cuenta_judicial","cuenta_judicial.IDNRO", "=","mov_cta_judicial.CTA_JUDICIAL")
                    ->whereColumn('cuenta_judicial.ID_DEMA', 'demandas2.IDNRO')
                    ->limit(1); 
            }, "=", 0)
           ->select("notificaciones.IDNRO" , "notificaciones.CI" ,"NOTIFI_1", DB::raw('DATEDIFF( NOTIFI_1, NOW()) AS NOTIFI1_V'),   "ADJ_AI",
            "INTIMACI_1",  DB::raw('DATEDIFF( INTIMACI_1, NOW()) AS INTIMACI1_V'),
            "INTIMACI_2",  DB::raw('DATEDIFF( INTIMACI_2, NOW()) AS INTIMACI2_V'), 
            "NOTIFI1_AI_TIT",  DB::raw('DATEDIFF( NOTIFI1_AI_TIT, NOW()) AS NOTIFI1_AI_TIT_V'),
            "NOTIFI1_AI_GAR",  DB::raw('DATEDIFF( NOTIFI1_AI_GAR, NOW()) AS NOTIFI1_AI_GAR_V'),
            "NOTIFI2_AI_TIT",  DB::raw('DATEDIFF( NOTIFI2_AI_TIT, NOW()) AS NOTIFI2_AI_TIT_V'),
            "NOTIFI2_AI_GAR",  DB::raw('DATEDIFF( NOTIFI2_AI_GAR, NOW()) AS NOTIFI2_AI_GAR_V'),
             "CITACION","NOTIFI_2" , DB::raw('DATEDIFF( NOTIFI_2, NOW()) AS NOTIFI2_V'),
             "NOTIFI_3" , DB::raw('DATEDIFF( NOTIFI_3, NOW()) AS NOTIFI3_V'),
             "NOTIFI_4" , DB::raw('DATEDIFF( NOTIFI_4, NOW()) AS NOTIFI4_V'),
             "NOTIFI_5" , DB::raw('DATEDIFF( NOTIFI_5, NOW()) AS NOTIFI5_V'),
             "ADJ_SD", "ADJ_APROBA",  "ADJ_OFICIO", "SALDO", "ADJ_LIQUI");
        //$sQ= $SEGUI_OBJ->toSql();
        
           $SEGUIMIENTO= $SEGUI_OBJ->get(); 
          // dd(DB::getQueryLog());
        foreach( $SEGUIMIENTO as $it):
            $FLAG= false;
             
            DB::beginTransaction();
            try{ //Primer escenario 
                 echo "CI ". $it->ADJ_AI;

             if( $this->fecha_valida($it->NOTIFI_1) && intval($it->NOTIFI1_V )<=0  &&  ( $it->ADJ_AI=="0000-00-00" ||  $it->ADJ_AI=="" ||  is_null($it->ADJ_AI) ) ){//adjunto autointerlocutorio sin fecha
              
                $fecha_ven= $this->get_fecha_vencimiento(  $it->NOTIFI_1 , 3 ) ;
                
                if($fecha_ven != ""  ) 
                {
                    $obs_notifi= "Notificacion 1. Adj. AI venció el ". $fecha_ven ; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_1,"FECHAV"=> $fecha_ven,
                     "OBS"=> $obs_notifi,"VENCIDO"=>"S"); 
                    $est=DB::table("vtos")->insert( $Datos); 
                    //Notificacion procesa S(si) N(no)
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                 }
            }elseif(intval($it->NOTIFI1_V )>0){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI_1,3 ) );
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_1,"FECHAV"=> $fecha_ven,"VENCIDO"=>"N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                } 
            }
            //Segundo Escenario Intimacion 1
            if( $this->fecha_valida( $it->INTIMACI_1) &&  intval($it->INTIMACI1_V) <= 0    &&  ($it->CITACION=="0000-00-00" || $it->CITACION=="") ){
                $fecha_ven=($this->get_fecha_vencimiento( $it->INTIMACI_1 )) ;
               
                if($fecha_ven != "") 
                {
                    $obs_notifi= "Intimacion 1, Citación venció el ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->INTIMACI_1,"FECHAV"=> $fecha_ven, 
                    "OBS"=> $obs_notifi , "VENCIDO"=> "S" );
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }elseif( intval($it->INTIMACI1_V) > 0){
                $fecha_ven=($this->get_fecha_vencimiento( $it->INTIMACI_1 )) ;
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->INTIMACI_1,"FECHAV"=> $fecha_ven, "VENCIDO"=>"N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }

             //Segundo Escenario Intimacion 2
             if( $this->fecha_valida( $it->INTIMACI_2) &&  intval($it->INTIMACI2_V) <= 0 &&   ($it->CITACION=="0000-00-00" || $it->CITACION=="") ){
                $fecha_ven=($this->get_fecha_vencimiento( $it->INTIMACI_2 )) ;
               
                if($fecha_ven != "") 
                {
                    $obs_notifi= "Intimacion 2, Citación venció el ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->INTIMACI_2,"FECHAV"=> $fecha_ven, 
                    "OBS"=> $obs_notifi , "VENCIDO"=> "S" );
                    $est=DB::table("vtos")->insert( $Datos); 
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }elseif( intval($it->INTIMACI2_V) > 0 ){
                $fecha_ven=($this->get_fecha_vencimiento( $it->INTIMACI_2 )) ; 
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->INTIMACI_2,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }  
            }
            //Tercer escenario
            if(  $this->fecha_valida($it->NOTIFI_2) &&  intval($it->NOTIFI2_V)<=0 &&    ($it->ADJ_SD=="0000-00-00" || $it->ADJ_SD=="") ){
                $fecha_ven= ($this->get_fecha_vencimiento( $it->NOTIFI_2 ))  ;
                 if($fecha_ven != "") 
                {
                    $obs_notifi= "Notificacion 2. Adj. SD. venció el ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_2,"FECHAV"=> $fecha_ven,
                     "OBS"=> $obs_notifi , "VENCIDO"=> "S" );
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }  
            }elseif( intval($it->NOTIFI2_V) > 0 ){
                $fecha_ven= ($this->get_fecha_vencimiento( $it->NOTIFI_2 ))  ; 
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_2,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                } 
            }
            //Cuarto escenario
            if( $this->fecha_valida($it->NOTIFI_3) && intval($it->NOTIFI3_V)<=0 ){
                $fecha_ven= ($this->get_fecha_vencimiento( $it->NOTIFI_3 ))  ;
                 if($fecha_ven != "") 
                {
                    $obs_notifi="Notificacion 3  venció el ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_3,"FECHAV"=> $fecha_ven,
                     "OBS"=> $obs_notifi, "VENCIDO"=>"S");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                 }
            }elseif(  intval($it->NOTIFI3_V) > 0  )  {
                $fecha_ven= ($this->get_fecha_vencimiento( $it->NOTIFI_3 )) ; 
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_3,"FECHAV"=> $fecha_ven,   "VENCIDO"=>"N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                 } 
            }
           
            //Quinto escenario
            if( $this->fecha_valida($it->NOTIFI_4) &&  intval($it->NOTIFI4_V)<=0 &&   ($it->ADJ_APROBA=="0000-00-00" || $it->ADJ_APROBA=="")){
                $fecha_ven= ($this->get_fecha_vencimiento( $it->NOTIFI_4 )) ;
                
                 if($fecha_ven != ""){ 
                    $obs_notifi= "Notificacion 4. Adj. Aprob. venció el ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_4,"FECHAV"=> $fecha_ven,
                     "OBS"=> $obs_notifi , "VENCIDO"=> "S"); 
                    $est=DB::table("vtos")->insert( $Datos);  
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }elseif(  intval($it->NOTIFI4_V) > 0 ){
                $fecha_ven= ($this->get_fecha_vencimiento( $it->NOTIFI_4 )) ; 
                if($fecha_ven != "") 
               {
                   $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_4,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                   $est=DB::table("vtos")->insert( $Datos); 
                   if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }
            //Sexto escenario
            if(  $this->fecha_valida($it->NOTIFI_5) &&  intval( $it->NOTIFI5_V )<=0 &&  ($it->ADJ_OFICIO=="0000-00-00" || $it->ADJ_OFICIO=="")  ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI_5)) ;
                 if($fecha_ven != "") 
                {
                    $obs_notifi= "Notificacion 5. Adj. Oficio. venció al ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_5,"FECHAV"=> $fecha_ven,
                     "OBS"=> $obs_notifi , "VENCIDO"=> "S");
                    $est=DB::table("vtos")->insert( $Datos); 
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }elseif(  intval( $it->NOTIFI5_V ) >0 ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI_5)) ;
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI_5,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }  
            }
             //Septimo escenario
             if(  $this->fecha_valida( $it->NOTIFI1_AI_TIT) &&   intval( $it->NOTIFI1_AI_TIT_V )<=0  ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI1_AI_TIT)) ;
                if($fecha_ven != "") 
                {
                    $obs_notifi= "Notificación 1 A.I. al titular venció al ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI1_AI_TIT,"FECHAV"=> $fecha_ven, 
                    "OBS"=> $obs_notifi, "VENCIDO"=> "S");
                    $est=DB::table("vtos")->insert( $Datos); 
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                } 
            }elseif( intval( $it->NOTIFI1_AI_TIT_V )  > 0 ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI1_AI_TIT)); 
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI1_AI_TIT,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                } 
            }
             //Octavo escenario
             if( $this->fecha_valida($it->NOTIFI1_AI_GAR ) &&   intval( $it->NOTIFI1_AI_GAR_V )<=0  ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI1_AI_GAR)) ;
                if($fecha_ven != "") 
                {
                    $obs_notifi= "Notificación 1 A.I. al garante venció al ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI1_AI_GAR,"FECHAV"=> $fecha_ven, 
                    "OBS"=> $obs_notifi, "VENCIDO"=> "S");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }elseif(  intval( $it->NOTIFI1_AI_GAR_V ) > 0 ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI1_AI_GAR)) ; 
                if($fecha_ven != "") 
                    {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI1_AI_GAR,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos);
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                } 
            }

            //Noveno escenario
            if(   $this->fecha_valida( $it->NOTIFI2_AI_TIT) &&   intval( $it->NOTIFI2_AI_TIT_V )<=0  ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI2_AI_TIT)) ;
                if($fecha_ven != "") 
                {
                    $obs_notifi= "Notificación 2 A.I. al Titular venció al ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI2_AI_TIT,"FECHAV"=> $fecha_ven, 
                    "OBS"=> $obs_notifi, "VENCIDO"=> "S");
                    $est=DB::table("vtos")->insert( $Datos); 
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }elseif(  intval( $it->NOTIFI2_AI_TIT_V ) > 0 ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI2_AI_TIT)) ; 
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI2_AI_TIT,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos); 
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
            }
            //decimo escenario
            if(  $this->fecha_valida( $it->NOTIFI2_AI_GAR) &&  intval( $it->NOTIFI2_AI_GAR_V )<=0  ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI2_AI_GAR)) ;
                if($fecha_ven != "") {
                    $obs_notifi= "Notificación 2 A.I. al Garante venció al ". $fecha_ven; 
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI2_AI_GAR,"FECHAV"=> $fecha_ven,
                     "OBS"=> $obs_notifi, "VENCIDO"=> "S");
                    $est=DB::table("vtos")->insert( $Datos);  
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                }
                
            }elseif( intval( $it->NOTIFI2_AI_GAR_V ) > 0  ){
                $fecha_ven= ($this->get_fecha_vencimiento(  $it->NOTIFI2_AI_GAR)) ; 
                if($fecha_ven != "") 
                {
                    $Datos= array(  "IDNRO"=>$it->IDNRO, "FECHA"=> $it->NOTIFI2_AI_GAR,"FECHAV"=> $fecha_ven, "VENCIDO"=> "N");
                    $est=DB::table("vtos")->insert( $Datos); 
                    if(!$FLAG) { $it->FLAG="S"; $it->save(); $FLAG= true; }
                } 
            }
            
            DB::commit();
        }//End try
        catch(Exception $e){   DB::rollBack();    break;}
        endforeach;
      return redirect(  "dema-noti-venc");
    }
/**
 * Lista de demandas con fecha de  notificaciones vencidas
 */
    public function notificaciones_venc(){
     
        $vtos= DB::table("vtos") 
        ->join("demandas2", "demandas2.IDNRO","=","vtos.IDNRO")
        ->join("demandado", "demandas2.CI","=","demandado.CI")
        ->join("demandan","demandas2.DEMANDANTE", "=","demandan.IDNRO", "left")
        ->select("demandas2.CI", "demandas2.IDNRO AS DEMANDA", "demandado.TITULAR","demandan.DESCR as DEMANDANTE","COD_EMP",
        "vtos.FECHA", "vtos.FECHAV","vtos.OBS",
        DB::raw('DATEDIFF( vtos.FECHAV, NOW()) AS VENCIDO') );

        if( strtolower(  request()->method()  )  == "post"){
            $datos= request();
            $modo= $datos['modo'];
            $Desde= $datos['Desde'];
            $Hasta= $datos['Hasta'];
            if($modo=="NV")
            $vtos= $vtos->where( DB::raw('DATEDIFF( vtos.FECHAV, NOW())'),">","0");
            if($modo=="V")
            $vtos= $vtos->where( DB::raw('DATEDIFF( vtos.FECHAV, NOW())'),"<=","0");
            if( $Desde!=""  &&  $Hasta!="")
            { 
                $vtos= $vtos->whereDate(  "vtos.FECHAV",">=", $Desde);
                $vtos= $vtos->whereDate(  "vtos.FECHAV","<=", $Hasta);
            }
        }

        $vtos=$vtos->paginate(20); 

        if( request()->ajax())
        return view('notificaciones.grilla', ['lista' => $vtos ]); 
        else
        return view('notificaciones.list_noti_venc', ['lista' => $vtos ]); 
    }


 



    public function borrar_noti_vencidas(){
        DB::beginTransaction();
       try{
        $borrar= DB::table("vtos")
        ->where("VENCIDO","=","S")
        ->delete();
        DB::commit();
        return redirect("dema-noti-venc");
       }catch(Exception $ex){
           DB::rollBack();
           echo "Error al borrar notificaciones vencidas";
       }
        
    }










    

public function  reporte( Request $request, $tipo="XLS" ){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
     // Genera un PDF
$vencidoparam=  $request->input("VENCIDO");

$resultados= DB::table("vtos") 
->join("demandas2", "demandas2.IDNRO","=","vtos.IDNRO")
->join("demandado", "demandas2.CI","=","demandado.CI")
->join("demandan","demandas2.DEMANDANTE", "=","demandan.IDNRO", "left")
->select("demandas2.CI", "demandas2.IDNRO AS DEMANDA", "demandado.TITULAR","demandan.DESCR as DEMANDANTE","COD_EMP",
"vtos.FECHA AS NOTIFICACION", "vtos.FECHAV as VENCIMIENTO",
DB::raw("IF( VENCIDO='S',  vtos.OBS,  CONCAT('FALTAN  ',CONCAT(DATEDIFF(FECHAV, NOW()), ' DIAS')  )) AS OBSERVACION"));


 
if( $vencidoparam=="V")
{
    $resultados=  $resultados->where("VENCIDO", "S"); 
}
if( $vencidoparam=="NV")
{
    $resultados=  $resultados->where("VENCIDO", "N"); 
}

$resultados=  $resultados->get();

if( $tipo=="XLS") echo json_encode(  $resultados);
else{


    //EJECUTAR;
        $Titulo=  "NOTIFICACIONES" ;
        $html=<<<EOF
         <style>
         th{
             font-size:6pt;
             font-weight: bold;
             background-color: #bac0fe;
             color: #060327
         }
        .ci{
            width: 50px;
        }
        .notificacion,.vencimiento{
            width: 62px;
        }
        .cod_emp{
            width: 55px;
        }
         .titular{
             width: 200px;
         }
          
         .row{
             font-size: 6pt;
         }
          
         </style>
         <table>
        <thead>
        <tr>
        EOF;
        
        //Columnas automaticas
        $cols=0;
         foreach( $resultados as $objeto):
            foreach( $objeto as $clave=>$valor):
                
               // if( $cols==10) break;
               $css_class= strtolower($clave);
               $html.="<th class=\"$css_class\">$clave</th>";
               
            endforeach;
        break;
         endforeach;
         $html.="</tr></thead><tbody>";
      
       foreach( $resultados as $objeto): 
            $html.='<tr class="row">';
            foreach($objeto as $clave=>$valor): 

                $css_class= strtolower($clave);
                $valor= ( $clave== "NOTIFICACION" ||  $clave== "VENCIMIENTO") ? Helper::beautyDate($valor) : $valor;
                $html.="<td class=\"$css_class\">$valor</td>";     
            endforeach;
            $html.="</tr>"; 
        endforeach; 


        $html.="</tbody></table>";

      // echo $html;
      if(  $tipo=="PRINT"){ echo $html; }
      else{
        $tituloDocumento= $Titulo."-".date("d")."-".date("m")."-".date("yy")."-".rand();
       $pdf = new PDF(); 
     $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $pdf->generar();  
        }
    }//END 
}






}