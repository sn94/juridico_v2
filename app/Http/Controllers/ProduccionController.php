<?php

namespace App\Http\Controllers;

use App\Banc_mov;
use App\CuentaJudicial;
use App\Demanda;
use App\Demandados;
use App\Filtros;
use App\Http\Controllers\Controller;
use App\Liquidacion;
use App\MovCuentaJudicial;
use App\Notificacion;
use App\ODemanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Parametros;
use App\pdf_gen\PDF;
use DeepCopy\Filter\Filter;
use Illuminate\Http\Client\Request as ClientRequest;
 
class ProduccionController extends Controller
{


    private $NUMEROCOLS=9;
     
    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   

 

    

private function tratar_fecha( $arg){
    $fecha= $arg;
    if( $fecha !="") {
        $elementos=  preg_split("/[\/-]/", $fecha);
        try{
            $nuevo=$elementos[2]."-".$elementos[1]."-".$elementos[0];
            if( strlen( $elementos[0] ) <4   )
            { 
                echo "  $fecha  = ".$nuevo."<br>";
               return $nuevo;
            }else return "";
            
        }catch(Exception $e){
            echo $e->getMessage();
            echo "Error:  $fecha<br>";
            return "";
        } 
    } return "";
}


//Seguimiento
public function COMPATIBILIDAD_FECHA_SEGUIMIENTO(){
    //Campos fecha de seguimiento
    $campos=[  'CI','PRESENTADO','PROVI_1','NOTIFI_1','ADJ_AI','AI_FECHA','INTIMACI_1',
    'INTIMACI_2','CITACION','PROVI_CITA','NOTIFI_2','ADJ_SD','SD_FECHA','NOTIFI_3','ADJ_LIQUI',
    'PROVI_2', 'NOTIFI_4', 'ADJ_APROBA', 'APRO_FECHA','ADJ_OFICIO', 'NOTIFI_5','EMB_FECHA',
     'FEC_FINIQU', 'FEC_INIVI', 'FEC_FINIQU'];
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Notificacion::get(); 
$nu=1;
    foreach( $rows as $ite){
        foreach( $campos as $campo):
        $fecha= $ite->{$campo};
        $nueva_Fecha= $this->tratar_fecha(  $fecha);
        if( $nueva_Fecha != "" )
       { $ite->{$campo}= $nueva_Fecha;
        $ite->save();} 
        endforeach;
    }
}



//EVITAR REDUNDANCIAS EN TABLAS AUXILIARES
public function TRATAR_REDUNDANCIA(){

    $DEMANDANTE= DB::table("demandan")->get();
    foreach( $DEMANDANTE as $ite){
        $descri= $ite->DESCR;
        DB::table("demandan")->where("DESCR", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
    $ORIGDEMANDA= DB::table("odemanda")->get();
    foreach( $ORIGDEMANDA as $ite){
        $descri= $ite->CODIGO;
        DB::table("odemanda")->where("CODIGO", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
    $JUZGADO= DB::table("juzgado")->get();
    foreach( $JUZGADO as $ite){
        $descri= $ite->DESCR;
        DB::table("juzgado")->where("DESCR", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
    $ACTUARIA= DB::table("actuaria")->get();
    foreach( $ACTUARIA as $ite){
        $descri= $ite->DESCR;
        DB::table("actuaria")->where("DESCR", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
    $JUEZ= DB::table("juez")->get();
    foreach( $JUEZ as $ite){
        $descri= $ite->DESCR;
        DB::table("juez")->where("DESCR", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
    $INSTITUCION= DB::table("instituc")->get();
    foreach( $INSTITUCION as $ite){
        $descri= $ite->DESCR;
        DB::table("instituc")->where("DESCR", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
    $INSTIPO= DB::table("instipo")->get();
    foreach( $INSTIPO as $ite){
        $descri= $ite->DESCR;
        DB::table("instipo")->where("DESCR", "$descri")->where("IDNRO","<>",$ite->IDNRO)->delete() ;
    }
}

//DEMANDA
public function COMPATIBILIDAD_FECHA_DEMANDA(){
    //Campos fecha de seguimiento
    $campos=[  'ADJ_LEV_EMB_FEC' , 'LEV_EMB_CAP_FEC', 'FEC_EMBARG'];
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Demanda::get(); 
    foreach( $rows as $ite){
        foreach( $campos as $campo):
        $fecha= $ite->{$campo};
        $nueva_Fecha= $this->tratar_fecha(  $fecha);
        if( $nueva_Fecha != "" )    $ite->{$campo}= $nueva_Fecha;
        endforeach; //end foreach fecha

        //claves foraneas DEMANDANTE 
        $demandante= $ite->DEMANDANTE;
        $obj1= DB::table("demandan")->where("DESCR", $demandante)->first();
        if( !is_null($obj1) )  $ite->DEMANDANTE= $obj1->IDNRO;  
    
     //claves foraneas ORIGEN DEMANDA 
        $odemand= $ite->O_DEMANDA;
        $obj2= DB::table("odemanda")->where("CODIGO", $odemand)->first();
        if( !is_null($obj2) ) $ite->O_DEMANDA= $obj2->IDNRO;  
    //claves foraneas JUZGADO
        $juzgado= $ite->JUZGADO;
        $obj3= DB::table("juzgado")->where("DESCR", $juzgado)->first();
        if( !is_null($obj3) ) $ite->JUZGADO= $obj3->IDNRO;  
    
     //claves foraneas actuaria 
        $actuaria= $ite->ACTUARIA;
        $obj4= DB::table("actuaria")->where("DESCR", $actuaria)->first();
        if( !is_null($obj4) ) $ite->ACTUARIA= $obj4->IDNRO; 
     //claves foraneas JUEZ 
        $juez= $ite->JUEZ;
        $obj5= DB::table("juez")->where("DESCR", $juez)->first();
        if( !is_null($obj5) ) $ite->JUEZ= $obj5->IDNRO; 
    //claves foraneas institucion
        $institu= $ite->INSTITUCIO;
        $obj6= DB::table("instituc")->where("DESCR", $institu)->first();
        if( !is_null($obj6 ) ) $ite->INSTITUCIO= $obj6->IDNRO; 
    //claves foraneas tipo de institucion 
        $instipo= $ite->INST_TIPO;
        $obj7= DB::table("instipo")->where("DESCR", $instipo)->first();
        if( !is_null($obj7) )  $ite->INST_TIPO= $obj7->IDNRO; 
        //SAVE
        $ite->save();//guardar todo
    }//end foreach

}



//CAlCULO DE LIQUIDACION
public function COMPATIBILIDAD_FECHA_LIQUIDA(){
    //Campos fecha de seguimiento
    $campos=[  'ULT_PAGO' , 'ULT_CHEQUE'];
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Liquidacion::get(); 
 
    foreach( $rows as $ite){
        foreach( $campos as $campo):
        $fecha= $ite->{$campo};
        $nueva_Fecha= $this->tratar_fecha(  $fecha);
        if( $nueva_Fecha != "" )
       { $ite->{$campo}= $nueva_Fecha;
        $ite->save();} 
        endforeach;
    }
    //aSOCIAR CON ID DE DEMANDA
    foreach( $rows as $ite){ 
        $cta= $ite->CTA_BANCO;
        $dema= Demanda::where("CTA_BANCO", $cta)->first();
        if( !is_null(  $dema) ){ $ite->ID_DEMA= $dema->IDNRO; $ite->save(); }
    }/*end foreach */ 

}



//CAlCULO DE LIQUIDACION
public function COMPATIBILIDAD_FECHA_BANCO(){
    //Campos fecha de seguimiento
    $campos=[  'FECHA'];
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Banc_mov::get(); 
 
    foreach( $rows as $ite){
        foreach( $campos as $campo):
        $fecha= $ite->{$campo};
        $nueva_Fecha= $this->tratar_fecha(  $fecha);
        if( $nueva_Fecha != "" )
       { $ite->{$campo}= $nueva_Fecha;
        $ite->save();} 
        endforeach;
    } 

}





//CAlCULO DE LIQUIDACION
public function COMPATIBILIDAD_SALDO_DEMANDA(){
     
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Demanda::get(); 
    DB::beginTransaction();
   try{
        foreach( $rows as $ite){
      
               // if(  $ite->SALDO == 0  ||  is_null( $ite->SALDO ) ){
                    
                    
                $judicialoptions=new JudicialController();
                $SALDO_CAPITAL=   $judicialoptions->saldo_C_y_L(  $ite->IDNRO, "array", true);
                $ite->SALDO=     $SALDO_CAPITAL['saldo_capital'];
               $ite->save();
           // }
        } 
        DB::commit();
   }catch (\Exception $e) {DB::rollback(); } 

}

//LIMPIEZA DE TELEFONOS
public function COMPATIBILIDAD_TELEFONOS(){
     
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Demandados::get(); 
    DB::beginTransaction();
   try{
        foreach( $rows as $ite){
      
               $TELE= $ite->TELEFONO;
               $CELU1= $ite->CELULAR;
               $CELU2= $ite->CELULAR2;
               $TELET= $ite->TEL_TRABAJ;
               $TELE_=  preg_replace("/[\.\-\/]/", " ", $TELE);
               $CELU1_=  preg_replace("/[\.*\-*\/*]/", " ", $CELU1);
               $CELU2_=  preg_replace("/[\.*\-*\/*]/", " ", $CELU2);
               $TELET_= preg_replace("/[\.*\-*]/", " ", $TELET);
               $ite->TELEFONO=  $TELE_;
               $ite->CELULAR=  $CELU1_;
               $ite->CELULAR2=  $CELU2_;
               $ite->TEL_TRABAJ=  $TELET_;
               echo  $TELE_. "  ".$CELU1_."  ".$CELU2_." ".$TELET_."<br>";
               $ite->save();
           // }
        } 
        DB::commit();
   }catch (\Exception $e) {DB::rollback(); } 

}
public function test(){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $rows=Demanda::get(); 
 
  
    foreach( $rows as $ite){
       $demandante= $ite->CI;
       $res= DB::table("demandan")->where("DESCR", $demandante)->first();
       if( !is_null($res) ){
           $ite->DEMANDANTE= $res->IDNRO;
           $ite->save();
       }
      
       
        
    }
  
   
}



}