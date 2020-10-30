<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CuentaJudicial;
use App\Demanda;
use App\Demandados;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Liquidacion;
use App\Notificacion;
use Exception;
use Illuminate\Support\Facades\DB; 
use App\pdf_gen\PDF;
use phpDocumentor\Reflection\Types\Null_;

class LiquidaController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }




   
    public function index( $iddeman){
        $obj_demanda= Demanda::find(  $iddeman);
        $lista= Liquidacion::where("CTA_BANCO",  $obj_demanda->CTA_BANCO)->get();
        /**PARAMS */
        $ci= $obj_demanda->CI; 
        $nombre= Demandados::where("CI", $ci)->first()->TITULAR;
        $cta_bco= $obj_demanda->CTA_BANCO;
        return view("liquidaciones.index",
         ["lista"=> $lista ,"CI"=>$ci, "TITULAR"=> $nombre, "CTA_BANCO"=> $cta_bco,
          "id_demanda"=> $obj_demanda->IDNRO] );
    }

    public function nuevo(Request $request, $iddeman=0){

        if( ! strcasecmp(  $request->method() , "post"))  {
               //Quitar el campo _token
               $Params=  $request->input(); 
               //Devuelve todo elemento de Params que no este presente en el segundo argumento
             /*  $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
                   if( $ar1 == $ar2) return 0;    else 1; 
                } ); */
        
           $cta= new Liquidacion();
           $cta->fill(  $Params);
           DB::beginTransaction();
           try {
            $cta->save(); 
             DB::commit();
             return view("liquidaciones.success",  ["iddeman"=> $request->input("ID_DEMA"), "mensaje"=>"LIQUIDACION REGISTRADA"] );
           } catch (\Exception $e) {
               DB::rollback();
               echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
           }  
        }
        else{
            $demandaob=Demanda::find( $iddeman);
            //Recuperar datos de otras tablas
            $ci= $demandaob->CI;
            $nombre=  Demandados::where("CI", $ci)->first()->TITULAR; 
            $cta_bco= $demandaob->CTA_BANCO;
            $N=Notificacion::find( $iddeman);
            $sdf= $N->SD_FINIQUI;
            $fecf= $N->FEC_FINIQU;
            $judici= new JudicialController();
            $saldo_j= $judici->saldo_C_y_L( $iddeman ); 
            return view('liquidaciones.cargar', 
            ["id_demanda"=>$iddeman, "CI"=>$ci, "TITULAR"=> $nombre, "CTA_BANCO"=> $cta_bco, 
            "SD_FINIQUI"=> $sdf,"FEC_FINIQU"=> $fecf, "CAPITAL"=> $demandaob->DEMANDA,
             "SALDO"=> $saldo_j['saldo_liquida'] , "OPERACION"=>"A"]); 
        } 
    }



    
    public function editar(Request $request, $idnro=0){

        if( ! strcasecmp(  $request->method() , "post"))  {
               //Quitar el campo _token
               $Params=  $request->input(); 
               //Devuelve todo elemento de Params que no este presente en el segundo argumento
               $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
                   if( $ar1 == $ar2) return 0;    else 1; 
                } ); 
                
           $cta= Liquidacion::find( $request->input("IDNRO") );
           $cta->fill(  $Newparams);
           DB::beginTransaction();
           try {
            $cta->save(); 
             DB::commit();
             return view("liquidaciones.success", ["mensaje"=>"LIQUIDACION ACTUALIZADA"]);
           } catch (\Exception $e) {
               DB::rollback();
               echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
           }  
        }
        else{
            $liqui= Liquidacion::find($idnro);
            $iddeman= Liquidacion::find( $idnro )->ID_DEMA;// ANALIZAR
            $demandaob=Demanda::where( "CTA_BANCO", $liqui->CTA_BANCO)->first();  $ci= $demandaob->CI; 
           /* $N=Notificacion::find( $iddeman);
            $sdf= $N->SD_FINIQUI;
            $fecf= $N->FEC_FINIQU;*/
            return view('liquidaciones.cargar', 
            ["id_demanda"=>$demandaob->IDNRO, "CI"=>$ci,   "CAPITAL"=> $demandaob->DEMANDA, "dato"=> $liqui , "OPERACION"=>"M"]); 
        } 
    }



    public function view( $idnro){
        $liqui= Liquidacion::find($idnro);
        $objLiqui= Liquidacion::find( $idnro );
        $demandaob=Demanda::where("CTA_BANCO", $objLiqui->CTA_BANCO)->first();  $ci= $demandaob->CI; 
        $N=Notificacion::find( $demandaob->IDNRO);
        $sdf= $N->SD_FINIQUI;
        $fecf= $N->FEC_FINIQU;
        return view('liquidaciones.cargar', 
        ["id_demanda"=>$demandaob->IDNRO, "CI"=>$ci,  "SD_FINIQUI"=> $sdf,"FEC_FINIQU"=> $fecf,
         "CAPITAL"=> $demandaob->DEMANDA, "dato"=> $liqui , "OPERACION"=>"V"]); 
    }



//************************LISTA DE LIQUIDACIONES******************** */
public function list( $iddeman){
    $obj_demanda= Demanda::find(  $iddeman);
    $lista= Liquidacion::where("CTA_BANCO",  $obj_demanda->CTA_BANCO)->get();
    return view("liquidaciones.grilla", ["lista"=> $lista, "id_demanda"=> $iddeman] );
}

 
public function list_json( $iddeman){
    $obj_demanda= Demanda::find(  $iddeman);
    $lista= Liquidacion::where("CTA_BANCO",  $obj_demanda->CTA_BANCO)->get();
   echo json_encode( $lista );
}

 
public function list_array( $iddeman){
    $obj_demanda= Demanda::find(  $iddeman);
    $lista= Liquidacion::where("CTA_BANCO",  $obj_demanda->CTA_BANCO)->get();
    return $lista;
}

/*********************************END LISTADO DE LIQUIDACIONES************** */








    public function delete( $idnro){
        $dat=Liquidacion::find(  $idnro);
        $dat->delete();
        echo json_encode( array("idnro"=>  $idnro) );
      //  return view("cta_judicial.mensaje_success2", ["mensaje"=> "Movimiento borrado"]); 
    }




 

/**
 * PDF FILES GENERATOR FUNCS
 */
 
     

public function reporte( $idnro, $tipo, $HTML= "N"){
    $DATO= Liquidacion::find(  $idnro);
    if( $tipo == "xls"){
        echo json_encode( array( "0"=> $DATO) );  
    }else{
        //Pdf format
        //Preparar variables que representan montos
        $TOTAL=  Helper::number_f( $DATO->TOTAL );
        $EXTRAIDO=Helper::number_f( $DATO->EXTRAIDO );
        $SALDO= Helper::number_f( $DATO->SALDO );
        $EXT_LIQUID=Helper::number_f( $DATO->EXT_LIQUID );
        $NEW_SALDO= Helper::number_f( $DATO->NEW_SALDO );
        $html=<<<EOF
        <style>
        h1,h2,h3,h4,h5,h6{  color: #151515;}
        span{
            font-weight: bolder;
        }
        .subtitulo{ font-size: 7pt; font-weight: bold; text-align: center;text-decoration: underline; background-color: #bcfdb0; border-bottom: 1px solid #8ef861;}
        .panel{
            margin-top:0px;
            border-top: 1px solid #797979;
            border-bottom: 1px solid #797979;
            border-left: 1px solid #797979;
            border-right: 1px solid #797979;
        } 
        td{ text-align:left; }
        table.tabla{ 
            font-family: helvetica;
            font-size: 7pt; 
            color: #151515;
        }
        </style>
        
        <h6>TITULAR: {$DATO->TITULAR}</h6>
        <table class="tabla">
        <tbody>
        <tr> 
        <td style='text-align:left;'>
        <span>CTA.BANCO:</span> {$DATO->CTA_BANCO}<br><br>
        <span>ULT.PAGO:</span> {$DATO->ULT_PAGO}<br><br>
        <span>ULT.CHEQUE:</span> {$DATO->ULT_CHEQUE}<br><br>
        </td>
        <td>
        <span>CTA.MESES:</span> {$DATO->CTA_MESES}<br><br>
        <span>INTERÉS POR MES:</span> {$DATO->INT_X_MES}<br><br>
        <span>LIQUIDACIÓN.:</span> {$DATO->LIQUIDACIO}
        </td>
        <td>
        <span>FINIQUITO:</span> {$DATO->FINIQUITO}<br><br>
        <span>IMP.EXTR.:</span> {$EXTRAIDO}<br><br>
        <span>SALDO:</span> {$SALDO}<br><br>
        </td>
        <td>
        <span>EXTR.LIQUID.:</span> {$EXT_LIQUID}<br><br>
        <span>NUEVO SALDO:</span> {$NEW_SALDO}
        </td>
        </tr> 
        </tbody> 
        </table> 
        <p class="subtitulo"> TOTALES</p>
        <table class="tabla panel">
        <tr>
        <td><span>CAPITAL:</span> {$DATO->CAPITAL}<br></td>
        <td><span>IMP.INTERÉS.:</span> {$DATO->IMP_INTERE}<br></td>
        <td><span>GAST.NOTIF.:</span> {$DATO->GAST_NOTIF}<br></td>
        <td><span>GAST.NOTIF.GTE.:</span> {$DATO->GAST_NOTIG}<br></td>
        </tr>
        <tr>
        <td><span>GAST.EMBARGO.:</span> {$DATO->GAST_EMBAR}<br></td>
        <td><span>GAST.INTIMAC.:</span> {$DATO->GAST_INTIM}<br></td>
        <td><span>I.V.A.:</span> {$DATO->IVA}<br></td>
        <td> <span>HONORARIOS.:</span> {$DATO->HONORARIOS}<br></td>
        </tr>
        <tr>
        <td><span>TOTAL:</span> $TOTAL <br></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
        </table>
        EOF; 
       // echo $html;

       if( $HTML=="N"){
        $tituloDocumento= "LIQUIDACION-".date("d")."-".date("m")."-".date("yy")."-".rand();
    
        // $this->load->library("PDF"); 	
         $pdf = new PDF(); 
         $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
         $pdf->generarHtml( $html);
         $pdf->generar();
       }else{ 
           echo $html;
       }
       

    }//End pdf format option
     

}//End reporte function

}