<?php

namespace App\Http\Controllers;

use App\Arreglo_extra_cuotas;
use App\Arreglo_extrajudicial;
use App\Banc_mov;
use App\Bancos;
use App\Demanda;
use App\Demandados;
use App\Helpers\Helper;
use App\Helpers\NumeroALetras;
use App\Http\Controllers\Controller;
use App\Notificacion;
use App\Recibo;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class ArregloExtrajudiController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  
     



    private  function generar_recibo( $cuota_pagad,  $acumu_pagos){
        $IDNRO= request()->input("IDNRO"); 
            $demanda= Demanda::find( $IDNRO);
            $demandado=  (new Demandados())->where("CI", $demanda->CI)->first(); 
            //Parametros
            $titular=  $demandado->TITULAR;
            $total= $acumu_pagos; 
            $fechadescri=  Helper::fechaDescriptiva();
                $cuots=  join(",", $cuota_pagad);
            $concepto="Pago de cuota(s) ($cuots) del Arreglo extrajudicial N° $IDNRO";

            //ID RECIBO
            $idnro_= [];
            //ULTIMO CODIGO
            $nroRecibos= Recibo::count();
            if( $nroRecibos == 0){
                $parametros=  DB::table("parametros")->first();
                $cod_recibo= $parametros->RECIBO;
                $cod_sgte= intval( $cod_recibo) + 1;
                $idnro_= [ 'IDNRO'=> $cod_sgte ];
            }
            $datosRecibo=['ARREGLO'=> $IDNRO, 'IMPORTE'=>$total, 'DEUDOR'=>$titular, 'CONCEPTO'=>$concepto,'FECHA_L'=>$fechadescri];

            $recibo= new Recibo();
            $recibo->fill( array_merge( $idnro_, $datosRecibo) );
            $recibo->save();
            return $recibo->IDNRO ;
    }


    public function agregar(Request $request){
        if( sizeof(  $request->all() )  > 0){

            //Transaccion
            DB::beginTransaction();

            try{
                $cabecera=  array_filter(  $request->input(), 
                function( $key){
                   return $key != "DETALLE";
               },  ARRAY_FILTER_USE_KEY);
               $IDNRO= $request->input("IDNRO");
                $arr=  Arreglo_extrajudicial::find(  $IDNRO ); //new Arreglo_extrajudicial();
                $arr->fill( $cabecera );
               $arr->save();
                //Registrar cuotas
                $detalle= $request->input("DETALLE"); 
                $arr->arreglo_extra_cuotas()->delete();//borrar cuotas
                $numero= 1;
                /**DATOS DE RECIBO */
                $acumu_pagos= 0;
                $cuota_pagad= [];
                for( $c=0;  $c< sizeof( $detalle['ARREGLO'] ) ; $c++){
                    //reiniciar
                    $cuo= new Arreglo_extra_cuotas();
                    $cuo->fill(  array(
                    'ARREGLO'=>  $detalle['ARREGLO'][$c],
                    'NUMERO'=> $numero,
                    'VENCIMIENTO'=>$detalle['VENCIMIENTO'][$c],
                    'IMPORTE'=>$detalle['IMPORTE'][$c] 
                    , 'FECHA_PAGO'=>  $detalle['FECHA_PAGO'][$c])   );
                    $cuo->save(); 
                    $numero++; 
                    if(  $detalle['FECHA_PAGO'][$c] != "" &&    $detalle['FECHA_PAGO'][$c] !="0000-00-00" )
                    {$acumu_pagos+=  intval( $detalle['IMPORTE'][$c] );
                    array_push($cuota_pagad, $numero );}
                } 
                //Actualizar campo Bandera en Demanda ARR_EXTRAJUDI 
                    $demanda= Demanda::find( $IDNRO);
                    $demanda->ARR_EXTRAJUDI= "S"; $demanda->save();
                    $seguimiento= Notificacion::find( $IDNRO);
                    $seguimiento->ARREGLO_EX=  "S"; $seguimiento->save();
            
                    
                //GENERAR RECIBO?
                if( $acumu_pagos > 0){
                    $reciboid= $this->generar_recibo($cuota_pagad, $acumu_pagos); 
                    DB::commit();
                    echo json_encode( array("print"=>  $reciboid)  );

                }else {
                    DB::commit();
                    echo json_encode( array("ok"=> "CUENTA GUARDADA." )  ); }

            }catch( \Exception $e){
                DB::rollback();
                echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
            }
        }else{ 
            echo json_encode( array("error"=> "DATOS NO RECIBIDOS." )  );
        }
       
    }

 


  
    public function borrar($idnro){
        $d=Bancos::find($idnro)->delete();
        echo json_encode( array("IDNRO"=> $idnro )  );
    }


 
  

    public function mostrarRecibo( $id_recibo, $opcion= "V"){

        if( request()->isMethod('post')){
            
            $id_recibo= request()->input("IDNRO") ;
            $recibo= Recibo::find(  $id_recibo );
            $recibo->fill(  request()->input() );
            if( $recibo->save() )
            echo json_encode(  array("ok"=>"Actualizado"));
            else echo json_encode(  array("error"=> ""));
        }else{
            $recibo= Recibo::find( $id_recibo);
      
            $IMPORTE=  $recibo->IMPORTE;
            $TITULAR= $recibo->DEUDOR;
            $IMPORTEL= (new NumeroALetras())->toWords( $IMPORTE);
            $CONCEPTO= $recibo->CONCEPTO;
            $FECHAL=  $recibo->FECHA_L;
            if( $opcion== "V"){
                return view("demandas.recibo",[   'NRORECIBO'=> $id_recibo, 'IMPORTE'=> $IMPORTE, 'IMPORTEL'=>$IMPORTEL, "DEMANDADO"=> $TITULAR , 
            "fechaletras"=>$FECHAL, "CONCEPTO"=>$CONCEPTO]); 
            }else{ 
                return view("demandas.recibo",[  'NRORECIBO'=> $id_recibo, 'IMPORTE'=> $IMPORTE, 'IMPORTEL'=>$IMPORTEL, "DEMANDADO"=> $TITULAR , 
            "fechaletras"=>$FECHAL, "CONCEPTO"=>$CONCEPTO, 'EDICION'=> true] ); 
            }
        }//Get Option
      
       
    }


    public function mostrarRecibos( $id_arreglo){
        //OBTENER INFO DE TODAS LAS CUOTAS DEL ARREGLO
        $arreglo = Arreglo_extra_cuotas::where( "ARREGLO", $id_arreglo )->get();

        $recibo= Recibo::where("ARREGLO", $id_arreglo)->get();
        return view("demandas.recibos",['RECIBOS'=> $recibo, "id_arreglo"=>$id_arreglo, "CUOTAS"=>$arreglo]);     
    }


     
 
}
