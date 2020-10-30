<?php

namespace App\Http\Controllers;
 
use App\Codigo_gasto;
use App\Demanda;
use App\Demandados;
use App\Gastos;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\pdf_gen\PDF;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class PlanCtaGastoController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  
    public function index(){
       // if ( $request->ajax() )
      
       $dato= Codigo_gasto::orderBy('IDNRO', 'desc')->paginate(20); 
       return view("plan_cuenta.index",
        ["lista"=>  $dato,  "url_agregar"=> url("plan-cuenta"), 
        "ruta_listado"=> url("plan-cuenta-list"),  "breadcrumbcolor"=>"#fdc673 !important;"] );
       
    }



    public function cargar(Request $request, $ope= "A", $id=""){
        
        if( sizeof(  $request->all() )  > 0){
            $cod_gasto=null;
            if( $ope == "A"){   $cod_gasto= new Codigo_gasto();    }  
            if( $ope == "M"){
                //cASO EDICION
                $cod_gasto=Codigo_gasto::find(  $request->input("IDNRO" )  );
            }//FIN EDICION    

            $grabar= false;

               //CONTROLAR REDUNDANCIA
               
               if(  Codigo_gasto::where("CODIGO",  $request->input("CODIGO" )  )->count() > 0) {
                   if( $ope == "A"){  $grabar=false;   echo json_encode( array("error"=> "CODIGO DE GASTO YA EXISTE" )  );}
                   else{
                       //edicion
                       if( $cod_gasto->CODIGO !=   $request->input("CODIGO" )  ){
                        $grabar= false;
                        echo json_encode( array("error"=> "CODIGO DE GASTO YA EXISTE" )  );
                    }else{  $grabar= true;}
                   } 
            }//FIN VERIFICACION REDUNDANCIA CODIGO
            else  $grabar= true;

            if( $grabar){
                 //avanzar
                 $cod_gasto->fill( $request->input() );
                 $cod_gasto->save();
                 echo json_encode( array("ok"=> $ope=="A" ? "SE AGREGÓ LA CTA. DE GASTO" :  "CUENTA DE GASTO EDITADO" )  );
            }

        }else{
            //Preparar parametros 
            $ruta=   $ope == "A" ? url("plan-cuenta")  :  url("plan-cuenta/M");
            if( $ope == "A")    
            return view("plan_cuenta.form",  
             ['OPERACION'=> $ope,   'RUTA'=> $ruta ]);
            if( $ope == "M") {
                $cod_gasto= Codigo_gasto::find( $id);
                return view("plan_cuenta.form", 
                  ['OPERACION'=> $ope,   'RUTA'=> $ruta,  'DATO'=>$cod_gasto ]);
            }
        }
    }

     
    

    public function borrar($idnro){
        if( Codigo_gasto::find($idnro)->delete())
        echo json_encode( array("ok"=> "BORRADO" )  );
        else
        echo json_encode( array("error"=> "NO SE PUDO BORRAR" )  );
    }


 
  


    public function listar( Request $request){  
        $dato= Codigo_gasto::orderBy('IDNRO', 'desc')->paginate(20); 
        if( $request->ajax())
        return view("plan_cuenta.grilla", ["lista"=>  $dato] );
        else
        return view("plan_cuenta.index",
        ["lista"=>  $dato, "url_agregar"=> url("plan-cuenta") ] );

    }

  




//tcpdf
//para clases css referenciarlas mediante comillas dobles
 
public function reporte(  $tipo="xls"){ 

    $Movi= Codigo_gasto::orderBy("CODIGO")->get(); 
   

    
    if( $tipo == "xls"){
        echo json_encode(   $Movi );  
    }else{
        //Pdf format
        //Preparar variables que representan montos
         
        $html= <<<EOF
        <style>
            tr.cabecera{
                font-size: 7pt;
                background-color: #c2fcca;
                font-weight: bold;
            }
            table.tabla{ 
                border-top: 1px solid #606060;
                border-bottom: 1px solid #606060;
            }
            tr.cuerpo{
                color: #363636;
                font-size: 9px;
                font-weight: bold;
            }
            
         
            
        </style>
        <h6>GASTOS - PLAN DE CUENTAS </h6>
        <table class="tabla">
        <thead>
        <tr class="cabecera"><th style="width: 100px;">CÓDIGO</th><th style="width: 320px;">DESCRIPCIÓN</th><th>CREADO</th></tr>
        </thead>
        <tbody>
        EOF; 
       /********/
       
       /********** */ 
        foreach( $Movi as $mo): 
            //con formato 
            $fechaCreacion= Helper::beautyDate( $mo->created_at );
            $html.= "<tr class=\"cuerpo\"> <td style=\"width: 100px;\">{$mo->CODIGO}</td><td style=\"width: 320px;\">{$mo->DESCRIPCION}</td><td>$fechaCreacion</td></tr> ";
        endforeach;  
 
        $html.= "</tbody></table>";
         
        $tituloDocumento= "GASTOS - PLAN DE CUENTAS -".date("d")."-".date("m")."-".date("yy")."-".rand();
        $pdf = new PDF(); 
        $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $pdf->generar();

    }//End pdf format option
     

}//End reporte function
 



public function demandas($CI){
    $titu= Demandados::where("CI", $CI)->first()->TITULAR;
    $demanda=Demanda::select( 'IDNRO', 'COD_EMP', 'DEMANDA', 'cod_gasto', 'CTA_cod_gasto')->where("CI",$CI)->get();
    return view("gastos.demanda_chooser", ['demandas'=> $demanda, 'TITULAR'=> $titu ]);
}






}
