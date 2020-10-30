<?php

namespace App\Http\Controllers;

use App\CuentaJudicial;
use App\Demanda;
use App\Demandados;
use App\Http\Controllers\Controller;
 
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;    
use App\pdf_gen\PDF; 
use App\Helpers\Helper;
use App\MovCuentaJudicial;

class InformesController extends Controller
{
     
    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   

    
    /**
    *Devuelve INFORMACION DETALLADA DE ARREGLOS EXTRAJUDICIALES
    *POR CADA CUOTA
    */
    public function informes_arr_extr(Request $request, $html= 'S' ){  
        $fecha= "";
        if( ! strcasecmp(  $request->method() , "post"))  {//hay datos 
     
        $Desde= $request->input("Desde");
        $Hasta= $request->input("Hasta");
        $fecha= "AND  arr_extr_cuotas.FECHA_PAGO>='$Desde' and 
        arr_extr_cuotas.FECHA_PAGO<='$Hasta' ";
        }
    
        $columnasMovil="";
        $columnasDesktop="";

        $lista= DB::select("SELECT  demandas2.CI,TITULAR , demandas2.DEMANDA,demandan.DESCR as DEMANDANTE,COD_EMP,arreglo_extrajudicial.TIPO,
          arreglo_extrajudicial.IMPORTE_T AS TOTAL,   (select count(*) from arr_extr_cuotas where arr_extr_cuotas.ARREGLO=demandas2.IDNRO) as CUOTAS, 
          (select count(*) from arr_extr_cuotas where arr_extr_cuotas.ARREGLO=demandas2.IDNRO   and arr_extr_cuotas.FECHA_PAGO is not null) as PAGADAS,
        IMPORTE, FECHA_PAGO from arr_extr_cuotas join 
        arreglo_extrajudicial on arreglo_extrajudicial.IDNRO=arr_extr_cuotas.ARREGLO join demandas2 on 
        demandas2.IDNRO=arreglo_extrajudicial.IDNRO join demandado on demandado.CI=demandas2.CI JOIN demandan on 
        demandan.IDNRO=demandas2.DEMANDANTE WHERE demandas2.ARR_EXTRAJUDI='S'  $fecha ");
    
        if( $request->ajax()){
            if($html == "S") //DEVOLVER DATOS CON FORMATO HTML
            return view('informes.arreglo_extraju.grilla_cuotas', 
            [ "lista"=> $lista] );
            else if($html=="N" || $html=="XLS") //DEVOLUCION DE LISTA EN JSON
            echo json_encode(  $lista );
        }
        else{
            if ( $html ==  "S")//cONTENIDO HTML
            return view('informes.arreglo_extraju.index_cuotas', 
            [ "lista"=> $lista, "TITULO"=>"Arreglos Extrajudiciales"] );
            if ( $html ==  "XLS" || $html=="N")//cONTENIDO JSON PARA XLS
            echo json_encode(  $lista ); 
            if ( $html ==  "PDF")//cONTENIDO PDF
            $this->reporte_arreglo_extrajudicial( "Arreglos Extrajudiciales",$lista);
            
        }
 
    } 

 /**
* DEVUELVE INFORMACION MAS SINTETICA QUE LA ANTERIOR PARA LOS ARREGLOS EXTRAJUDICIALES
 */

 public function informes_arreglos_resumen(Request $request, $html= 'S' ){  
        $fecha= "";
        if( ! strcasecmp(  $request->method() , "post"))  {//hay datos 
     
   /*     $Desde= $request->input("Desde");
        $Hasta= $request->input("Hasta");
        $fecha= "AND  arr_extr_cuotas.FECHA_PAGO>='$Desde' and 
        arr_extr_cuotas.FECHA_PAGO<='$Hasta' ";*/
        }
     

        $lista= DB::select("SELECT demandas2.IDNRO, demandas2.CI,demandas2.COD_EMP,TITULAR , demandas2.DEMANDA,
        demandan.DESCR as DEMANDANTE,COD_EMP,arreglo_extrajudicial.TIPO, arreglo_extrajudicial.IMPORTE_T AS TOTAL,
         (select count(*) from arr_extr_cuotas where arr_extr_cuotas.ARREGLO=demandas2.IDNRO) as CUOTAS, 
         (select count(*) from arr_extr_cuotas where arr_extr_cuotas.ARREGLO=demandas2.IDNRO and 
         arr_extr_cuotas.FECHA_PAGO is not null) as PAGADAS from arreglo_extrajudicial join demandas2 
         on demandas2.IDNRO=arreglo_extrajudicial.IDNRO join demandado on demandado.CI=demandas2.CI left JOIN
         demandan on demandan.IDNRO=demandas2.DEMANDANTE WHERE arreglo_extrajudicial.IMPORTE_T > 0     ");
    
        if( $request->ajax()){
            if($html == "S") //DEVOLVER DATOS CON FORMATO HTML
            return view('informes.arreglo_extraju.grilla', 
            [ "lista"=> $lista] );
            else if ( $html ==  "PRINT")//cONTENIDO para imprimir
            return view('informes.arreglo_extraju.grilla_print', 
            [ "lista"=> $lista] );

            else if($html=="N" || $html=="XLS") //DEVOLUCION DE LISTA EN JSON
            echo json_encode(  $lista );
        }
        else{
            if ( $html ==  "S")//cONTENIDO HTML
            return view('informes.arreglo_extraju.index', 
            [ "lista"=> $lista, "TITULO"=>"Arreglos Extrajudiciales"] );

            if ( $html ==  "PRINT")//cONTENIDO para imprimir
            return view('informes.arreglo_extraju.grilla_print', 
            [ "lista"=> $lista] );

            if ( $html ==  "XLS" || $html=="N")//cONTENIDO JSON PARA XLS
            echo json_encode(  $lista ); 
            if ( $html ==  "PDF")//cONTENIDO PDF
            $this->reporte_arreglo_extrajudicial( "Arreglos Extrajudiciales", $lista);
            
        }
 
    } 




/**
 * estado de cuenta judicial
 */
 
 
public function informes_cuenta_judicial(Request $request, $html= 'S' ){  
   /* set_time_limit(0);
    ini_set('memory_limit', '-1');*/
    $CEDULA = $request->input("CEDULA"); 
  
    //var_dump( $CEDULA);
    $lista= [];
   if( $CEDULA != "")
    {
        $Sql = "select demandado.IDNRO as DEMANDADO, demandas2.IDNRO as ID_DEMANDA, demandado.CI, 
        demandan.DESCR as DEMANDANTE, TITULAR, COD_EMP, DEMANDA, CTA_BANCO, ( CASE WHEN (TIPO_MOVI='D') THEN IMPORTE ELSE '****' END) AS DEPOSITO, 
        ( CASE WHEN (TIPO_MOVI='E' AND TIPO_CTA='C') THEN IMPORTE ELSE '****' END) AS 'EXT.CAPITAL',
        ( CASE WHEN (TIPO_MOVI='E' AND TIPO_CTA='L') THEN IMPORTE ELSE '****' END ) AS 'EXT.LIQUIDACION' 
         from mov_cta_judicial inner join cuenta_judicial on cuenta_judicial.IDNRO = mov_cta_judicial.CTA_JUDICIAL 
         inner join demandas2 on demandas2.IDNRO = cuenta_judicial.ID_DEMA left join demandan on 
         demandas2.DEMANDANTE = demandan.IDNRO inner join demandado on demandado.CI = demandas2.CI where demandado.CI = ? 
         order by DEMANDANTE asc ";
       /* $lista=  MovCuentaJudicial::
        join("cuenta_judicial", "cuenta_judicial.IDNRO", "=", "mov_cta_judicial.CTA_JUDICIAL")
        ->join("demandas2", "demandas2.IDNRO", "=", "cuenta_judicial.ID_DEMA")
        ->join("demandan", "demandas2.DEMANDANTE", "=","demandan.IDNRO", "left")
        ->join("demandado", "demandado.CI", "=", "demandas2.CI")
        ->select( "demandado.IDNRO as DEMANDADO", "demandas2.IDNRO AS ID_DEMANDA","demandado.CI", "demandan.DESCR as DEMANDANTE","TITULAR","COD_EMP","DEMANDA","CTA_BANCO","IMPORTE","TIPO_MOVI","TIPO_CTA")
        ->where("demandado.CI", $CEDULA)
        ->orderBy("DEMANDANTE")->get();*/
 

    $lista= DB::select( $Sql, [ $CEDULA  ] );
 
    }

    if( $request->ajax()){
        if($html == "S") //DEVOLVER DATOS CON FORMATO HTML
        return view('informes.cta_judicial.grilla', 
        [ "lista"=> $lista] );
        else if($html=="N" || $html=="XLS") //DEVOLUCION DE LISTA EN JSON
        echo json_encode(  $lista );
    }
    else{
        if ( $html ==  "S")//cONTENIDO HTML
        {
            return view('informes.cta_judicial.index', 
            [ "lista"=> $lista, "TITULO"=>"ESTADO DE CUENTA JUDICIAL", "CEDULA"=>$CEDULA ] );
        }
        if ( $html ==  "XLS" || $html=="N")//cONTENIDO JSON PARA XLS
        echo json_encode(  $lista ); 
        if ( $html ==  "PDF")//cONTENIDO PDF
        $this->reporte_cuenta_judicial( "ESTADO DE CUENTA JUDICIAL", $lista);
        
    }

} 











/**
 * 
 */

 

 
 

public function  reporte_arreglo_extrajudicial( $Titulo,  $resultados){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
     // Genera un PDF

    //EJECUTAR;
        $Titulo=  $Titulo ;
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
            text-align: center;
         }
         .titular{
             width: 150px;
         }
         .total,.demanda{
             text-align: right;
         }
         .cuotas{
            text-align: center;
            width: 40px;
         }
         .demandante, .tipo,.pagadas{
            text-align: center;
         }
         .row{
             font-size: 6pt;
         }
         .col{
             display:inline;
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
                if( $clave == "IDNRO") continue;
               // if( $cols==10) break;
               $css_class= strtolower($clave);
               $html.="<th class=\"$css_class\">$clave</th>";
              /* if( $clave == "CI") $html.="<th class=\"ci\">$clave</th>";
               else{ 
                  if( $clave == "TITULAR") $html.="<th class=\"titular\">$clave</th>";
                  else{
                      if($clave=="CUOTAS" || $clave=="PAGADAS") $html.="<th class=\"ci\">$clave</th>";
                      else  $html.="<th>$clave</th>";
                  }
                }*/
            endforeach;
        break;
         endforeach;
         $html.="</tr></thead><tbody>";
      //  $html.= "<th>CI°</th><th>TITULAR</th><th>DEMANDA</th><th>DEMANDANTE</th><th>COD_EMP</th><th>TIPO</th><th>TOTAL</th><th>CUOTAS</th><th>PAGADAS</th><th>IMPORTE</th><th>FECHA PAGO</th></tr></thead><tbody>";
    
       /* foreach($resultados as $objeto):
            $html.="<tr class=\"row\"><td>$objeto->CI</td><td>$objeto->TITULAR</td><td>$objeto->DEMANDA</td><td>$objeto->DEMANDANTE</td><td>$objeto->COD_EMP</td><td>$objeto->TIPO</td><td>$objeto->IMPORTE_T</td><td>$objeto->CANTCUOT</td><td>$objeto->CUOTPAGADA</td><td>$objeto->IMPORTE</td><td>".Helper::fecha_dma($objeto->FECHA_PAGO)."</td></tr>";
        endforeach;*/
        
        
       foreach( $resultados as $objeto): 
            $html.='<tr class="row">';
            foreach($objeto as $clave=>$valor):
                if( $clave == "IDNRO") continue;
                $css_class= strtolower($clave);
                $valor= ( $clave== "TOTAL" ||  $clave== "DEMANDA") ? Helper::number_f($valor) : $valor;
                $html.="<td class=\"$css_class\">$valor</td>";


               // $valor=   ($clave== "TOTAL" ||  $clave== "DEMANDA")? Helper::number_f($valor): $valor;
                //aSIGNAR CLASES CSS
               /* if( $clave == "CI" || $clave=="CUOTAS" || $clave=="PAGADAS") $html.="<td class=\"ci\">$valor</td>";
                else{
                    if( $clave == "TITULAR") $html.="<td class=\"titular\">$valor</td>";
                    else {
                        if( $clave== "TOTAL" ||  $clave== "DEMANDA")  $html.="<td class=\"total\">$valor</td>";
                        else $html.="<td>". $valor."</td>";
                    }
                }*/
           
                
            endforeach;
            $html.="</tr>"; 
        endforeach; 


        $html.="</tbody></table>";

      // echo $html;
        $tituloDocumento= $Titulo."-".date("d")."-".date("m")."-".date("yy")."-".rand();
       $pdf = new PDF(); 
     $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $pdf->generar();  
         
}

 
 






public function  reporte_cuenta_judicial( $Titulo,  $resultados){
    set_time_limit(0);
    ini_set('memory_limit', '-1');
     // Genera un PDF

    //EJECUTAR;
        $Titulo=  $Titulo ;
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
            text-align: center;
         }
         .titular{
             width: 150px;
         }
         .total,.demanda{
             text-align: right;
         }
         .cuotas{
            text-align: center;
            width: 40px;
         }
         .demandante, .tipo,.pagadas{
            text-align: center;
         }
         .row{
             font-size: 6pt;
         }
         .col{
             display:inline;
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
                if( $clave == "DEMANDADO" ||  $clave == "ID_DEMANDA"  ) continue;
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
                if( $clave == "DEMANDADO" ||  $clave == "ID_DEMANDA"  ) continue;
                $css_class= strtolower($clave);
                $valor= ( $clave== "IMPORTE" ||  $clave== "DEMANDA") ? Helper::number_f($valor) : $valor;
                $html.="<td class=\"$css_class\">$valor</td>";     
            endforeach;
            $html.="</tr>"; 
        endforeach; 


        $html.="</tbody></table>";

      // echo $html;
        $tituloDocumento= $Titulo."-".date("d")."-".date("m")."-".date("yy")."-".rand();
       $pdf = new PDF(); 
     $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $pdf->generar();  
         
}






}