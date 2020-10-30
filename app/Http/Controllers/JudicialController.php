<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CuentaJudicial;
use App\Demanda;
use App\Demandados;
use App\Http\Controllers\Controller;
use App\Liquidacion;
use App\MovCuentaJudicial;
use App\Notificacion;
use Exception;
use Illuminate\Support\Facades\DB; 

class JudicialController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }




    public function index( $iddeman){

        $DEMANDA=Demanda::find( $iddeman);

        $ctajudiOb= CuentaJudicial::where("ID_DEMA", $iddeman)->first();
        $CTA_JUDICIAL_ID= null;
        $movis= null;

        if(  !is_null($ctajudiOb) )
       { $CTA_JUDICIAL_ID=   $ctajudiOb->IDNRO;
        //grilla de movimiento
        $movis=CuentaJudicial::find( $CTA_JUDICIAL_ID)->movcuentajudicial;}

         //Datos pers
         $ci= $DEMANDA->CI;
         $nombre=  Demandados::where("CI", $ci)->first()->TITULAR; 

        return view('cta_judicial.index',
         ["ci"=>$ci, "nombre"=> $nombre, "id_demanda"=> $iddeman,   "movi"=> $movis]); 
    }


   public function listar($iddeman){
        //grilla de movimiento
        $ob=Demanda::find( $iddeman);
        $movis=CuentaJudicial::where("CTA_JUDICI", $ob->CTA_BANCO )->first()->movcuentajudicial;
        return view('cta_judicial.grilla', ["movi"=>$movis] );
   }

    public function nuevo(Request $request, $iddeman=0){

        if( ! strcasecmp(  $request->method() , "post"))  {
            //Quitar el campo _token
            $Params=  $request->input();  
            //Tipo de movimiento por Capital o por liquidacion
            $ID_CTA_JUDI=  $Params['CTA_JUDICIAL'] ;
            $objetoCtaJudi= CuentaJudicial::find( $ID_CTA_JUDI );
            $ID_DEMANDA= $objetoCtaJudi->ID_DEMA;
            $saldo_capital_now= $this->saldo_C_y_L(  $ID_DEMANDA )['saldo_capital'];
            if( $saldo_capital_now <= 0)//sI SALDO CAPITAL ES MENOR O IGUAL A CERO, EL TIPO DE EXTRACCION SERA
            $Params['TIPO_CTA']="L";    //POR LIQUIDACION
            /**************** */
           $cta= new MovCuentaJudicial();
           $cta->fill(  $Params);
      
           DB::beginTransaction();
           try {
                $cta->save(); 
                //Si fue extraccion de capital
                if(  $Params['TIPO_CTA']  == "C"  &&  $Params['TIPO_MOVI']== "E"){
                    $dema= Demanda::find($ID_DEMANDA);
                    $dema->SALDO= intval(  $dema->SALDO ) -  intval( $Params['IMPORTE']);
                    $dema->save();
                }
                DB::commit();
                //Volver a listado de movimientos de cuenta judicial
                echo json_encode( [ "go" => url("ctajudicial/$ID_DEMANDA") ]);
               // return view("cta_judicial.mensaje_success");
           } catch (\Exception $e) {
               DB::rollback();
               echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
           }  
        }
        else{
            $demandaob=Demanda::find( $iddeman);
            //Verificar si ya existe cuenta judicial para la Demanda
            $cuenta_j= CuentaJudicial::where("ID_DEMA", $iddeman)->first();
            
                if( is_null( $cuenta_j) ){
                    //Si no existe crear
                $cuenta_j= new CuentaJudicial();
                $cuenta_j->ID_DEMA= $iddeman;
                $cuenta_j->BANCO= $demandaob->BANCO;
                $cuenta_j->save();
                } 
             //Parametros
             $CTA_JUDICIAL= $cuenta_j->IDNRO;
             $BANCO= $cuenta_j->BANCO;
             $CTA_BANCO= $cuenta_j->CTA_JUDICI;
 
             //Datos pers Filtrar
             $CI= Demanda::find( $cuenta_j->ID_DEMA )->CI;
             $TITULAR= Demandados::where("CI", $CI)->first()->TITULAR; 
             /******** */
          
            //Activar o no opcion deposito
            $flag_deposito_opc= ParamController::get_param("DEPOSITO_CTA_JUDICI")=="S" ? "" : "disabled";
            //Mostrar vista
            return view('cta_judicial.cargar', 
            ["CTA_JUDICIAL"=> $CTA_JUDICIAL, 'BANCO'=>$BANCO,'CTA_BANCO'=>$CTA_BANCO,
            "CI"=>$CI, "TITULAR"=> $TITULAR,    'id_demanda'=> $cuenta_j->ID_DEMA,
            'flag_deposito_opc'=> $flag_deposito_opc ,  "OPERACION"=>"A"]); 
        } 
    }



    
    public function editar(Request $request, $idnro=0){//ID DE MOVIMIENTO

        if( ! strcasecmp(  $request->method() , "post"))  {
               //Quitar el campo _token
            $Params=  $request->input();  

           $cta= MovCuentaJudicial::find( $idnro);
           
           DB::beginTransaction();
           try {
            $ID_DEMANDA=  CuentaJudicial::where("IDNRO", $cta->CTA_JUDICIAL)->first()->ID_DEMA;
            //Si fue extraccion de capital
            if(  $Params['TIPO_CTA']  == "C"  &&  $Params['TIPO_MOVI']== "E"){
                if(  !is_null($ID_DEMANDA))
                {$dema= Demanda::find($ID_DEMANDA);
                $TEMPOSALDO= intval(  $dema->SALDO )  +  $cta->IMPORTE;
                $dema->SALDO= $TEMPOSALDO -  intval( $Params['IMPORTE']);
                $dema->save();}
            }
            $cta->fill(  $Params);
            $cta->save(); 
             DB::commit();
               //Volver a listado de movimientos de cuenta judicial
               echo json_encode( [ "go" => url("ctajudicial/$ID_DEMANDA") ]); 
           } catch (\Exception $e) {
               DB::rollback();
               echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
           }  
        }
        else{
            $movimiento= MovCuentaJudicial::find( $idnro);
            //Parametros
            $CTA_JUDICIAL= $movimiento->CTA_JUDICIAL;

            $OBJETO_CTA_JUD= CuentaJudicial::find( $CTA_JUDICIAL);//-------------
            $BANCO= $OBJETO_CTA_JUD->BANCO;
            $CTA_BANCO= $OBJETO_CTA_JUD->CTA_JUDICI;

            //Datos pers Filtrar
            $CI= Demanda::find( $OBJETO_CTA_JUD->ID_DEMA )->CI;
            $TITULAR= Demandados::where("CI", $CI)->first()->TITULAR; 
            /******** */
              //Activar o no opcion deposito
            $flag_deposito_opc= ParamController::get_param("DEPOSITO_CTA_JUDICI")=="S" ? "" : "disabled";
            return view('cta_judicial.cargar',
             ["CTA_JUDICIAL"=> $CTA_JUDICIAL, 'BANCO'=>$BANCO,'CTA_BANCO'=>$CTA_BANCO,
              "CI"=>$CI, "TITULAR"=> $TITULAR,  'id_demanda'=> $OBJETO_CTA_JUD->ID_DEMA, "dato"=> $movimiento, 
             'flag_deposito_opc'=> $flag_deposito_opc, "OPERACION"=>"M"]); 
        }

      
    }



    public function view( $idnro){//id de mov
        //Parametros
        $dato=  MovCuentaJudicial::find($idnro);
        $CTA_JUDICIAL= $dato->CTA_JUDICIAL;

        $OBJETO_CTA_JUD= CuentaJudicial::find( $CTA_JUDICIAL);//-------------
        $BANCO= $OBJETO_CTA_JUD->BANCO;
        $CTA_BANCO= $OBJETO_CTA_JUD->CTA_JUDICI;

        //Datos pers Filtrar
        $CI= Demanda::find( $OBJETO_CTA_JUD->ID_DEMA )->CI;
        $TITULAR= Demandados::where("CI", $CI)->first()->TITULAR; 
        /******** */

            //Activar o no opcion deposito
        $flag_deposito_opc= ParamController::get_param("DEPOSITO_CTA_JUDICI")=="S" ? "" : "disabled";

        return view("cta_judicial.cargar",
         ["CTA_JUDICIAL"=> $CTA_JUDICIAL, 'BANCO'=>$BANCO,'CTA_BANCO'=>$CTA_BANCO,
         "CI"=>$CI, "TITULAR"=> $TITULAR, 'id_demanda'=> $OBJETO_CTA_JUD->ID_DEMA, "dato"=> $dato, "OPERACION"=>"V",  
         'flag_deposito_opc'=> $flag_deposito_opc] );
    }


    public function delete( $idnro){
        $dat=MovCuentaJudicial::find(  $idnro);

        DB::beginTransaction();
        try {
         //Si fue extraccion de capital
        if(  $dat->TIPO_CTA  == "C"  &&  $dat->TIPO_MOVI == "E"){
            $ID_DEMANDA=  CuentaJudicial::where("IDNRO", $dat->CTA_JUDICIAL)->first()->ID_DEMA;
            if(  !is_null($ID_DEMANDA))
            {$dema= Demanda::find($ID_DEMANDA);
            $dema->SALDO= intval(  $dema->SALDO ) +  intval( $dat->IMPORTE  );
            $dema->save();
            }
        }
        
        $dat->delete();
        DB::commit();
        echo json_encode( array("idnro"=>  $idnro) );
        }catch(Exception $ex){
            DB::rollBack();
        }
      //  return view("cta_judicial.mensaje_success2", ["mensaje"=> "Movimiento borrado"]); 
    }


 /*   public function ver_saldo_all( ){
        //SALDO JUDICIAL
        //monto de la demanda - extracciones
        $demanda_=Demanda::sum("DEMANDA");
        $SaldoJudicial=  intval($demanda_);
        $Extracciones=0;
        $mov_cta_jud=CuentaJudicial::where( "TIPO_MOVI", "E")->get();
        foreach( $mov_cta_jud as $it):
            if(  $it->TIPO_MOVI == "E") //extracciones
            $Extracciones+=  intval(  $it->IMPORTE);
        endforeach;
        $SaldoJudicial-= $Extracciones;
        // SALDO EN CUENTA
        //depositos - extracciones
        $Depositos=0; 
        foreach( $mov_cta_jud as $it):
            if(  $it->TIPO_MOVI == "D")
            $Depositos+=  intval(  $it->IMPORTE);
        endforeach;
        $SaldoEnCuenta= $Depositos - $Extracciones; 

        return array("saldo_judi"=> $SaldoJudicial, "saldo_en_c"=> $SaldoEnCuenta);
    }*/

   /* public function ver_saldo_array( $iddeman){
         //****************SALDO JUDICIAL ************
        //monto de la demanda - extracciones
        $demanda_=Demanda::find( $iddeman);  //Buscar demanda por su ID
        $SaldoJudicial=  intval($demanda_->DEMANDA);//Monto de la demanda
        $Extracciones=0;
        $dt=CuentaJudicial::where( "CTA_JUDICI", $demanda_->CTA_BANCO)->get();//Instancia de cta judicial de la demanda
        foreach( $dt as $it):
            if(  $it->TIPO_MOVI == "E") //Si es extraccion
            $Extracciones+=  intval(  $it->IMPORTE);
        endforeach;
        $SaldoJudicial-= $Extracciones; // Restar del monto de demanda las extracciones
        //***********SALDO EN CUENTA**********  
        //depositos - extracciones
        $Depositos=0; 
        foreach( $dt as $it):
            if(  $it->TIPO_MOVI == "D") //deposito
            $Depositos+=  intval(  $it->IMPORTE);
        endforeach;
        $SaldoEnCuenta= $Depositos - $Extracciones; //Restar de los depositos acumula. las extracciones ya calculadas
        return array("saldo_judi"=> $SaldoJudicial, "saldo_en_c"=> $SaldoEnCuenta);
    }*/

  /*  public function ver_saldo( $iddeman){
        echo json_encode(  $this->ver_saldo_array( $iddeman ));
    }*/




//CALCULO DE SALDOS PARA UN JUICIO
//Saldo capital
// Saldo capital -  (Extracciones capital  )
//Saldo liquidacion - (extracciones liquidacion)

public function saldo_C_y_L(  $iddeman, $tipo="array" , $reparar= false ){
      //monto de la demanda - extracciones
      $demanda_reg=Demanda::find( $iddeman);  //Buscar demanda por su ID


     // $MontoDemanda=  intval($demanda_reg->DEMANDA);//Monto de la demanda
      //Consultar registro
      $liquidacion_reg=Notificacion::find( $iddeman);
      $total_liquidaciones= 0;
      if( !is_null($liquidacion_reg) )
      $total_liquidaciones=  intval(  $liquidacion_reg->LIQUIDACIO );

      //EXTRACCIONES
     // $Extracciones_capital=0;
      $Extracciones_liquida=0;
      $Extracciones_capital=0;
if(  intval($demanda_reg->SALDO)== 0  ||   ( is_null( $demanda_reg->SALDO ))  ||   $reparar){
    $cta_judi_reg=CuentaJudicial::where( "ID_DEMA", $iddeman)->first();
    if( !is_null($cta_judi_reg)){
        $MOVIS= $cta_judi_reg->movcuentajudicial;//Instancia de cta judicial de la demanda
        if(  ! is_null($MOVIS)):
        //Extracciones de capital    
        foreach( $MOVIS as $it):
                if(  $it->TIPO_MOVI == "E"  &&  $it->TIPO_CTA == "C") //Si es extraccion CAPITAL
                $Extracciones_capital+=  intval(  $it->IMPORTE);
        endforeach;
    endif;
    }
}//end verificacion cero
  
/*
          //Extracciones de liquidacion    
          foreach( $MOVIS as $it):
            if(  $it->TIPO_MOVI == "E"  &&  $it->TIPO_CTA == "L") //Si es extraccion CAPITAL
            $Extracciones_liquida+=  intval(  $it->IMPORTE);
            endforeach;
        endif;
    }*/
    
  //Calculo de saldos
    //SALDO CAPITAL
   // $saldo_capital= $MontoDemanda -  $Extracciones_capital;
   $saldo_capital_respaldo=  intval($demanda_reg->DEMANDA) - $Extracciones_capital;

   $saldo_capital=
    (intval($demanda_reg->SALDO)== 0   ||   ( is_null( $demanda_reg->SALDO )  || $reparar)  ) ?  $saldo_capital_respaldo :   $demanda_reg->SALDO;
    $saldo_liquida= $total_liquidaciones- $Extracciones_liquida;

     
    $data=array( "saldo_capital"=> $saldo_capital, "saldo_liquida"=> $saldo_liquida);
    
    /********************* */
      //Validar saldo si esta vacio
      if(  ( intval( $demanda_reg->SALDO)  == 0)    || ( is_null( $demanda_reg->SALDO ))  ||  $reparar ){
        $demanda_reg->SALDO=  $saldo_capital_respaldo;
        $demanda_reg->save();
    }
    /******************** */
    if( $tipo== "array")
    return $data;
    if( $tipo== "json")
    echo json_encode($data);
}
 


public function saldos_C_y_L(){
$id_deman_list= Demanda::select('IDNRO')->get();
//Totalizar demandas
$total_demandas= Demanda::sum("DEMANDA");  
//Totalizar extracciones de capital
$total_extr_capital= MovCuentaJudicial::where("TIPO_CTA", "C")->where("TIPO_MOVI","E")->sum("IMPORTE");
//Saldo capital
$saldo_C=  $total_demandas - $total_extr_capital;

//Totalizar liquidaciones
$total_liquidaciones=  Notificacion::sum("LIQUIDACIO");
//tOTALIZAR extracciones de liquidacion
$total_extr_liquida= MovCuentaJudicial::where("TIPO_CTA", "L")->where("TIPO_MOVI","E")->sum("IMPORTE");
 //sALDO liquidacion
 $saldo_L=  $total_liquidaciones - $total_extr_liquida;

 return array( "saldo_capital"=> $saldo_C, "saldo_liquida"=> $saldo_L );
}




public function saldos_C_y_L_lite(){
   // $id_deman_list= Demanda::select('IDNRO')->get();
    //Totalizar demandas
    //$total_demandas= Demanda::sum("DEMANDA");  
    //Totalizar extracciones de capital
    //$total_extr_capital= MovCuentaJudicial::where("TIPO_CTA", "C")->where("TIPO_MOVI","E")->sum("IMPORTE");
    //Saldo capital
   // $saldo_C=  $total_demandas - $total_extr_capital;
    $saldo_C=  Demanda::sum("SALDO");  
    //Totalizar liquidaciones
    $total_liquidaciones=  Notificacion::sum("LIQUIDACIO");
    //tOTALIZAR extracciones de liquidacion
    $total_extr_liquida= MovCuentaJudicial::where("TIPO_CTA", "L")->where("TIPO_MOVI","E")->sum("IMPORTE");
     //sALDO liquidacion
     $saldo_L=  $total_liquidaciones - $total_extr_liquida;
    
     return array( "saldo_capital"=> $saldo_C, "saldo_liquida"=> $saldo_L );
    }
    
























  

 



    //************************************************************ */
    //depositos en la cta judicial
    /************************************************************** */
    public function deposito_en_cuenta()
    {

        $dts = DB::select('select d.CTA_BANCO,d.TITULAR,d.FECHA,d.IMPORTE from demandas de  join deposito d on de.CTA_BANCO=d.CTA_BANCO order by d.CTA_BANCO,de.CTA_BANCO');

        return view('cta_judicial.deposito_cuenta', ['lista' => $dts]); 
    }
//extracciones de la cta judicial
    public function extraccion_cuenta()
    {

        $dts = DB::select('select d.CTA_BANCO,d.TITULAR,d.FECHA,d.IMPORTE from demandas de  join deposito d on de.CTA_BANCO=d.CTA_BANCO order by d.CTA_BANCO,de.CTA_BANCO');

        return view('cta_judicial.extraccion_cuenta', ['lista' => $dts]); 
    }

     
/**SUMAS */
public static function total_deposito_en_cuenta($id_cta_judi)
{
    $dts =  MovCuentaJudicial::where("TIPO_MOVI", "D")->where("CTA_JUDICIAL", $id_cta_judi)->sum("IMPORTE");
    return $dts;
}

public static function total_capital_en_cuenta($id_cta_judi)
{
    $dts =  MovCuentaJudicial::where("TIPO_MOVI", "E")->where("TIPO_EXT", "C")->where("CTA_JUDICIAL", $id_cta_judi)->sum("IMPORTE");
    return $dts;
}

public static function total_liquida_en_cuenta($id_cta_judi)
{
    $dts =  MovCuentaJudicial::where("TIPO_MOVI", "E")->where("TIPO_EXT", "L")->where("CTA_JUDICIAL", $id_cta_judi)->sum("IMPORTE");
    return $dts;
}


}