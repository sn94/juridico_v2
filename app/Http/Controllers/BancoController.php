<?php

namespace App\Http\Controllers;

use App\Arreglo_extrajudicial;
use App\Banc_mov;
use App\Bancos;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\pdf_gen\PDF;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class BancoController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  
    public function index(){
       // if ( $request->ajax() )
      
       $dato= Bancos::get();
       return view("bancos.index", ["movi"=>  $dato, "breadcrumbcolor"=>"#a3c5fc;"] );
       
    }



    public function informes( $tipo="html"){ 
        $datos= request()->input();

        $banco_obj= DB::table("ctas_banco")->join("ctasban_mov", "ctasban_mov.IDBANCO", "=", "ctas_banco.IDNRO")
        ->select("TITULAR","ctas_banco.CUENTA","ctas_banco.BANCO", DB::raw("IF(TIPO_MOV='D', IMPORTE,'') AS DEPOSITO"),
        DB::raw("IF(TIPO_MOV='E', IMPORTE,'') AS EXTRACCION"), "FECHA" );
      
        if( sizeof( $datos) ){
            if(  $datos['CUENTA'] != "" )
            $banco_obj= $banco_obj->where("ctas_banco.CUENTA",   $datos['CUENTA'] ); 
            if(  $datos['Desde'] != ""      &&    $datos['Hasta'] != "" )
            $banco_obj= $banco_obj->whereDate("FECHA", ">=",  $datos['Desde']  )->whereDate("FECHA", "<=", $datos['Hasta']);
        }
        $lista_cruda= $banco_obj;
        $banco_obj=  $banco_obj->get();

       
        if( request()->ajax())
        {
            if( $tipo=="html")
            return view("bancos.grilla_plain", ["movi"=>  $banco_obj, "breadcrumbcolor"=>"#a3c5fc;"] );
            if( $tipo=="json")
            echo json_encode(  $banco_obj );
            if( $tipo=="pdf")
            $this->reporte_movimientos_b64("BANCOS", $lista_cruda);
        }
        else{
            if($tipo== "html")
            return view("bancos.informe", ["movi"=>  $banco_obj, "breadcrumbcolor"=>"#a3c5fc;"] );
            if($tipo== "pdf")
            $this->reporte_movimientos("MOVIMIENTOS DE CUENTAS BANCARIAS", $lista_cruda);
        }
       
     }




    public function agregar(Request $request){
        if( sizeof(  $request->all() )  > 0){
            //Verificar si ya existe el numero de cuenta
            $posibleCoincidencia= Bancos::where("CUENTA",  $request->input("CUENTA")  )->first();
            if( !is_null($posibleCoincidencia)){
                echo json_encode( array("error"=> "ESTE NUMERO DE CUENTA YA EXISTE." )  );
            }else{
                $banco=new Bancos();
                $banco->fill( $request->input() );
                $banco->save();
                echo json_encode( array("ok"=> "CUENTA GUARDADA." )  );
            }
           
        }else{
            return view("bancos.form", ['OPERACION'=>"A", 'RUTA'=>url("nbank")]);
        }
       
    }

    public function editar(Request $request, $id=0){
        if( sizeof(  $request->all() )  > 0){
            $banco=Bancos::find( $request->input("IDNRO" ) );
            $banco->fill( $request->input() );
            $banco->save();
            echo json_encode( array("ok"=> "CUENTA ACTUALIZADA." )  );
        }
        else{
            $d=Bancos::find($id);
            return view("bancos.form", ["dato"=> $d, 'OPERACION'=>"M", 'RUTA'=>url("ebank")]);
        }
    }


    public function editar_movimiento(Request $request, $id=0){
        if( sizeof(  $request->all() )  > 0){
            $banco=Banc_mov::find( $request->input("IDNRO" ) );
            $banco->fill( $request->input() );
            $banco->save();
            echo json_encode( array("ok"=> "ACTUALIZADO." )  );
        }
        else{
            $d=Banc_mov::find($id);
            return view("bancos.form_movi",
             ["dato"=> $d,'TIPO_MOV'=>$d->TIPO_MOV,"TITULAR"=>$d->TITULAR,"CUENTA"=>$d->CUENTA,
             'BANCO'=>$d->BANCO,  'OPERACION'=>"M", 'RUTA'=>url("emovibank")]);
        }
    }

    public function borrar($idnro){
        $d=Bancos::find($idnro)->delete();
        echo json_encode( array("IDNRO"=> $idnro )  );
    }


    public function borrar_movimiento($idnro){
        $d=Banc_mov::find($idnro)->delete();
        echo json_encode( array("IDNRO"=> $idnro )  );
    }

  


    public function listar(){
        $dato=Bancos::all();
        return view("bancos.grilla", ["movi"=> $dato]);   
    }

    public function listar_movimiento(){
         //Consultar depositos y extracciones
         $SQL="SELECT ctasban_mov.*,ctas_banco.CUENTA,ctas_banco.TITULAR FROM ctas_banco,ctasban_mov where ctas_banco.CUENTA=ctasban_mov.CUENTA AND ctas_banco.BANCO=ctasban_mov.BANCO";
         $MOVS = DB::select( $SQL) ;
         return view("bancos.grilla_mov", ["dato"=> $MOVS] );
    }

    public function deposito(Request $request, $idnro=0){
        if( sizeof(  $request->all() )  > 0){

            DB::beginTransaction();
            try { 
                $dep=new Banc_mov();
                $dep->fill( $request->input());
                $dep->save(); 
                //Modificar saldo
                $Cta= $request->input("CUENTA");
                $Banc=Bancos::where("CUENTA", $Cta)->first();
                $Banc->SALDO= intval( $Banc->SALDO) + intval( $request->input("IMPORTE") );
                $Banc->save();
                DB::commit();
               echo json_encode( array( "ok"=>"DEPÓSITO REGISTRADO") );
             } catch (\Exception $e) {
                 DB::rollback();
                 echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
             } 
            /**end transac */
        }
        else{
            $b=Bancos::find($idnro);
            return view("bancos.form_movi", 
            ["TITULAR"=>$b->TITULAR,"CUENTA"=>$b->CUENTA,'BANCO'=>$b->BANCO,'TIPO_MOV'=>"D", 'RUTA'=> url("depobank") ]);
        }   
    }





    public function extraccion(Request $request, $idnro=0){
        if( sizeof(  $request->all() )  > 0){

            DB::beginTransaction();
            try { 
                $ex=new Banc_mov();
                $ex->fill( $request->input());
                $ex->save(); 
                //Modificar saldo
                $Cta= $request->input("CUENTA");
                $Banc=Bancos::where("CUENTA", $Cta)->first();
                $Banc->SALDO= intval( $Banc->SALDO) - intval( $request->input("IMPORTE") );
                $Banc->save();
                DB::commit();
               echo json_encode( array( "ok"=>"EXTRACCIÓN REGISTRADA") );
             } catch (\Exception $e) {
                 DB::rollback();
                 echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
             } 
            /**end transac */
        }
        else{
            $b=Bancos::find($idnro);
            return view("bancos.form_movi", 
            ["TITULAR"=>$b->TITULAR,"CUENTA"=>$b->CUENTA,'BANCO'=>$b->BANCO,'TIPO_MOV'=>"E", 'RUTA'=> url("extrbank") ]);
        }   
    }


    public function ViewCtaBanco( $id ){
        $dato= Bancos::find( $id);
        $IDNRO= $dato->IDNRO;
        $Cta= $dato->CUENTA;
        $Bco= $dato->BANCO;
        $Titular= $dato->TITULAR;

        //Consultar depositos y extracciones 
        $MOVS = $dato->banc_mov;
        return view("bancos.movimientos",
         [ 'IDNRO'=>$IDNRO,'TITULAR'=>$Titular,'BANCO'=>$Bco,'CUENTA'=>$Cta,'LINK'=>url("lmovibank")."/$id",
         "dato"=> $MOVS,  "breadcrumbcolor"=>"#a3c5fc;" ]);        
    }




//tcpdf
//para clases css referenciarlas mediante comillas dobles
 
public function reporte( $idnro, $tipo="xls"){ 

    $Bank= Bancos::find(  $idnro);
    
    $Movi= $Bank->banc_mov; 
    
    if( $tipo == "xls"){
        echo json_encode(   $Movi );  
    }else{
        //Pdf format
        //Preparar variables que representan montos
         
        $html= <<<EOF
        <style>
            .fecha{
                width:80px;
            }
            .debito,.credito{
                text-align: right;
                width: 80px;
            }
            .comprobante{
                width:90px;
            }
            .detalle{
                width:250px;
                text-align:left;
            }
            tr.cabecera{
                font-size: 7pt;
                background-color: #c2fcca;
                font-weight: bold;
            }
          
            tr.cuerpo{
                color: #363636;
                font-size: 8px;
                font-weight: bold;
            }
            
            tr.pie td{ 
                color: #0f0f0f;
                font-weight: bold;
                font-size: 9px; 
            }
            .saldo-ok{
                color: #035009;
            }
            .saldo-rojo{
                color: #b80c07;
            }
            
        </style>
        <h6>BANCO: {$Bank->BANCO},CUENTA N°: {$Bank->CUENTA}</h6>
        <table class="tabla">
        <thead>
        <tr class="cabecera"><th class="fecha">FECHA</th><th class="comprobante">COMPROBANTE</th><th class="detalle">DETALLE DE TRANS.</th><th class="debito">DÉBITO</th><th class="credito">CRÉDITO</th></tr>
        </thead>
        <tbody>
        EOF; 
       
        foreach( $Movi as $mo): 
            $debito= $mo->TIPO_MOV=="E" ?  $mo->IMPORTE : "*****"; 
            $credito=  $mo->TIPO_MOV=="D" ?  $mo->IMPORTE : "*****";
            //con formato
            $f_debito= Helper::number_f( $debito );
            $f_credito= Helper::number_f( $credito );
            $concepto= trim($mo->CONCEPTO);
            $html.= "<tr class=\"cuerpo\"> <td class=\"fecha\">{$mo->FECHA}</td><td class=\"comprobante\">{$mo->NUMERO}</td><td class=\"detalle\">$concepto</td><td class=\"debito\">$f_debito</td><td class=\"credito\">$f_credito</td></tr> ";
        endforeach; 
        //Sumas y saldo
        $deb= $Movi->where("TIPO_MOV","E")->sum("IMPORTE");
        $cred= $Movi->where("TIPO_MOV","D")->sum("IMPORTE");
        //con formato
        $f_deb= Helper::number_f( $deb);
        $f_cred= Helper::number_f( $cred);

        $saldo= $cred - $deb;
        $f_saldo= Helper::number_f( $saldo );//con formato
        $tr_saldo='saldo-ok';
        if( $saldo < 0)  $tr_saldo="saldo-rojo"; 
        $html.= <<<EOF
        <tr class="pie"><td class="fecha"></td><td class="comprobante"></td><td class="detalle">SUMAS</td><td class="debito">$f_deb</td><td class="credito">$f_cred</td></tr>
        <tr class="pie"><td class="fecha"></td><td class="comprobante"></td><td class="detalle"></td><td class="debito">SALDO</td><td  class="$tr_saldo credito">$f_saldo</td></tr>
        </tbody></table>
        EOF;
        // echo $html;
        if( $tipo == "PRINT"){
            echo  $html;
        }else{
            $tituloDocumento= "EXTRACTO-".date("d")."-".date("m")."-".date("yy")."-".rand();
            $pdf = new PDF(); 
            $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
            $pdf->generarHtml( $html);
            $pdf->generar();
        }  
    

    }//End pdf format option
     

}//End reporte function
 



/*
$b64Doc = chunk_split(base64_encode(file_get_contents($this->pdfdoc)));
*/

public function  reporte_movimientos( $Titulo,  $dts){
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
         .cuenta{
            width: 55px;
            text-align: center;
         }
         .banco{
            width: 40px;
            text-align: center;
         }
         .titular{
             width: 95px;
         }
         .deposito,.extraccion, .fecha{
            width: 60px;
             text-align: right;
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
        $resultados=  $dts->get();
         foreach( $resultados as $objeto):
            foreach( $objeto as $clave=>$valor): 
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
                $valor= ( $clave== "DEPOSITO" ||  $clave== "EXTRACCION") ? Helper::number_f($valor) : ( $clave=="FECHA"? Helper::beautyDate($valor): $valor);
                $html.="<td class=\"$css_class\">$valor</td>";   
                
            endforeach;
            $html.="</tr>";  
        endforeach; 

        //total deposito y extraccion
        $totales= $dts;
        $tot_= $totales->sum("IMPORTE"); ;
        $tot_depo= $dts->where("TIPO_MOV","D")->sum("IMPORTE"); 
        $tot_extr= abs(  intval($tot_) - $tot_depo );
        
        $tot_depo_= Helper::number_f($tot_depo); 
        $tot_extr_= Helper::number_f($tot_extr);   

        $html.= <<<EOF
        <tr class="row"><td class="titular"></td><td class="banco"></td><td class="cuenta"></td><td class="deposito">$tot_depo_</td><td class="extraccion">$tot_extr_</td><td class="fecha"></td></tr>
        </tbody></table>"
        EOF;

      // echo $html;
        $tituloDocumento= $Titulo."-".date("d")."-".date("m")."-".date("yy")."-".rand();
       $pdf = new PDF(); 
     $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $pdf->generar();  
         
}




public function  reporte_movimientos_b64( $Titulo,  $dts){
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
         .cuenta{
            width: 55px;
            text-align: center;
         }
         .banco{
            width: 40px;
            text-align: center;
         }
         .titular{
             width: 95px;
         }
         .deposito,.extraccion, .fecha{
            width: 60px;
             text-align: right;
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
        $resultados=  $dts->get();
         foreach( $resultados as $objeto):
            foreach( $objeto as $clave=>$valor): 
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
                $valor= ( $clave== "DEPOSITO" ||  $clave== "EXTRACCION") ? Helper::number_f($valor) : ( $clave=="FECHA"? Helper::beautyDate($valor): $valor);
                $html.="<td class=\"$css_class\">$valor</td>";   
                
            endforeach;
            $html.="</tr>";  
        endforeach; 

        //total deposito y extraccion
        $totales= $dts;
        $tot_= $totales->sum("IMPORTE"); ;
        $tot_depo= $dts->where("TIPO_MOV","D")->sum("IMPORTE"); 
        $tot_extr= abs(  intval($tot_) - $tot_depo );
        
        $tot_depo_= Helper::number_f($tot_depo); 
        $tot_extr_= Helper::number_f($tot_extr);   

        $html.= <<<EOF
        <tr class="row"><td class="titular"></td><td class="banco"></td><td class="cuenta"></td><td class="deposito">$tot_depo_</td><td class="extraccion">$tot_extr_</td><td class="fecha"></td></tr>
        </tbody></table>"
        EOF;

      // echo $html;
        $tituloDocumento= $Titulo."-".date("d")."-".date("m")."-".date("yy")."-".rand();
       $pdf = new PDF(); 
     $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
        $pdf->generarHtml( $html);
        $salida= $pdf->generar_v2();  
        $b64Doc = chunk_split(base64_encode(file_get_contents($salida)));
        echo $b64Doc;
         
}






//CODIGO DE COMPATIBILIDAD


public function  importar_registros(){


    //Obtener instancias de movimiento de cuenta
    //Actualizar el campo IDBANCO de los mismos
    $Bancos= Bancos::get();
    DB::beginTransaction();
    try{

        foreach($Bancos as $banco){
            $idnro=  $banco->IDNRO;
            $movs= Banc_mov::where("CUENTA", $banco->CUENTA)->get();
            foreach( $movs as $movimiento){
                $movimiento->IDBANCO= $idnro; 
                $val= $movimiento->save();
                
                echo "$val<br>";
            }
        }
        DB::commit();
    }catch (\Exception $e) {
        DB::rollback();
        echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
    } 
  

}




}
