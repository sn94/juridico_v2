<?php

namespace App\Http\Controllers;

use App\Arreglo_extrajudicial;
use App\Banc_mov;
use App\Bancos;
use App\Codigo_gasto;
use App\CodigoGasto;
use App\Demanda;
use App\Demandados;
use App\Gastos;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\pdf_gen\PDF;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class GastosController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  
    public function index( Request $request){
     
       $dato= Gastos::addSelect(['CODIGO' => Codigo_gasto::select('CODIGO')
       ->whereColumn('IDNRO', 'gastos.CODIGO') 
   ])->paginate(20); 
       

   if ( $request->ajax() )
       {
            if($dato->count() )
             return view("gastos.grilla", ["movi"=>  $dato ] );
             else
             echo "<h6>SIN REGISTROS</h6>";
        }
    else
        return view("gastos.index",
        ["movi"=>  $dato, "TITULO"=>"GASTOS", "url_agregar"=> url("gasto"), 
        "CODGASTO"=> DB::table("cod_gasto")->pluck( 'DESCRIPCION', 'IDNRO'),
            "breadcrumbcolor"=>"#fdc673 !important;"] );
       
    }



    public function ordenar( Request $request, $columna, $sentido){
           
        $orden= $sentido== "A" ?"ASC" : "DESC";
       $dato= Gastos::addSelect(['CODIGO' => Codigo_gasto::select('CODIGO')
       ->whereColumn('IDNRO', 'gastos.CODIGO') 
   ])->orderBy($columna, $orden )->paginate(20); 


   if( $request->ajax()){
        if($dato->count() )
        return view("gastos.grilla", ["movi"=>  $dato ] );
        else
        echo "<h6>SIN REGISTROS</h6>";
   }else{
        return view("gastos.index",
        ["movi"=>  $dato, "TITULO"=>"GASTOS", "url_agregar"=> url("gasto"), 
        "CODGASTO"=> DB::table("cod_gasto")->pluck( 'DESCRIPCION', 'IDNRO'),
            "breadcrumbcolor"=>"#fdc673 !important;"] );
   }
       
    }

    public function cargar(Request $request, $ope= "A", $id=""){
        
        if( sizeof(  $request->all() )  > 0){
            $banco=null;
            if( $ope == "A")   $banco=new Gastos();
            if( $ope == "M")   $banco= Gastos::find(  $request->input("IDNRO" )  );
            $banco->fill( $request->input() );
            $banco->save();
            $mensaje= ( $ope == "A") ?  "SE CARGÓ UN GASTO." : "GASTO EDITADO";
            echo json_encode( array("ok"=> $mensaje )  );

        }else{
            //Preparar parametros
            //Lista de codigo de gastos
            $cod_gastos=DB::table("cod_gasto")->pluck( 'DESCRIPCION', 'IDNRO');
            $ruta=   $ope == "A" ? url("gasto")  :  url("gasto/M");
            if( $ope == "A")    
            return view("gastos.form",  
             ['OPERACION'=> $ope,   'RUTA'=> $ruta,   'CODGASTO' => $cod_gastos ,"breadcrumbcolor"=>"#fdc673 !important;" ]);
            if( $ope == "M") {
                $el_gasto= Gastos::find( $id);
                //El gasto fue por demanda u otros
                if( is_null( $el_gasto->ID_DEMA ) )  //POR VARIOS
                return view("gastos.form", 
                  ['OPERACION'=> $ope,   'RUTA'=> $ruta,   'CODGASTO' => $cod_gastos ,
                  'dato'=>$el_gasto, "breadcrumbcolor"=>"#fdc673 !important;" ]);
                  else
                { //POR DEMANDA
                      $detalles_dema= DB::table("demandas2")->select("demandas2.CI","COD_EMP","DEMANDA","TITULAR")->join("demandado", "demandado.CI","=","demandas2.CI")
                      ->where("demandas2.IDNRO",   $el_gasto->ID_DEMA )
                      ->first(); 
                      return view("gastos.form", 
                        ['OPERACION'=> $ope,   'RUTA'=> $ruta,   'CODGASTO' => $cod_gastos , "demanda"=> $detalles_dema,
                        'dato'=>$el_gasto, "breadcrumbcolor"=>"#fdc673 !important;" ]);
                    }
            }
        }
    }

     
    

    public function borrar($idnro){
        $d=     Gastos::find($idnro)->delete();
        echo json_encode( array("IDNRO"=> $idnro )  );
    }


 
  public function filtrarPorCodigo( Request $request, $codigo){
    $dato= Gastos::addSelect(['CODIGO' => Codigo_gasto::select('CODIGO')
    ->whereColumn('IDNRO', 'gastos.CODIGO') 
])->where("CODIGO", $codigo)->paginate(20); 
if( $request->ajax())
{
    return view("gastos.grilla", ["movi"=>  $dato] );
}else{
    return view("gastos.index",
["movi"=>  $dato, "TITULO"=>"GASTOS", "url_agregar"=> url("gasto"),
 "breadcrumbcolor"=>"#fdc673 !important;"] );
}
  }

  private function listar_datos_segun_param($request){
    
    $dato= null;
    if( ! strcasecmp(  $request->method() , "post"))  {

        //Filtro por mo
        $modo= $request->input("modo");
        // Filtro de fecha
        $desde= $request->input("Desde");
        $hasta= $request->input("Hasta"); 

        $query=Gastos::
        addSelect(['COD_GASTO' => Codigo_gasto::select('CODIGO')
        ->whereColumn('IDNRO', 'gastos.CODIGO') 
        ])
        -> addSelect(['COD_EMP' => Demanda::select('COD_EMP')
        ->whereColumn('IDNRO', 'gastos.ID_DEMA') 
        ]);
         
        if( $desde != ""  && $hasta!= "") $query->whereDate("FECHA", ">=", $desde)->whereDate("FECHA", "<=", $hasta);
        if( $modo == "D")  $query->where("ID_DEMA","<>","NULL" );
        if( $modo == "V")  $query->whereNull('ID_DEMA');
        $dato= $query->paginate(20); 
         
    }
    else{  
        //$dato= Gastos::paginate(20);  
        $dato=  Gastos::addSelect(['CODIGO' => Codigo_gasto::select('CODIGO')
        ->whereColumn('IDNRO', 'gastos.CODIGO') 
    ])->paginate(20); 
  }
    return $dato;
  }

    public function listar( Request $request){  
        $dato= $this->listar_datos_segun_param( $request);
        if( $request->ajax())
        {
            return view("gastos.grilla", ["movi"=>  $dato] );}
        else
        {
            return view("gastos.index",
        ["movi"=>  $dato, "TITULO"=>"GASTOS", "url_agregar"=> url("gasto"),
        "CODGASTO"=> DB::table("cod_gasto")->pluck( 'DESCRIPCION', 'IDNRO'),
         "breadcrumbcolor"=>"#fdc673 !important;"] );}

    }

  




//tcpdf
//para clases css referenciarlas mediante comillas dobles
 
public function reporte(Request $request,  $tipo="xls"){ 
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $Movi=  $this->listar_datos_segun_param( $request);
    if( $tipo == "xls"){
        echo json_encode(   $Movi );  
    }else{
        //Pdf format
        //Preparar variables que representan montos
         
        $html= <<<EOF
        <style>
            .codigo{
                width: 65px;
            }
            .fecha{
                width:70px;
                text-align: left;
            }
            .comprobante{
                width: 110px;
            }
            .detalle{
                width: 200px;
                text-align: center;
            }
            .importe{
                width:100px;
                text-align: right;
            }
            tr.cabecera{
                font-size: 7pt;
                background-color: #c2fcca;
                font-weight: bold;
            }
            
            tr.cuerpo{
                color: #363636;
                font-size: 9px;
                font-weight: bold;
            }
            
            tr.pie td{ 
                color: #0f0f0f;
                font-weight: bold;
                font-size: 11px; 
            }
        </style>
        <h6>GASTOS</h6>
        <table class="tabla">
        <thead>
        <tr class="cabecera"><th class="codigo">CODIGO</th><th class="fecha">FECHA</th><th class="comprobante">COMPROBANTE</th><th class="detalle">DETALLES</th><th class="importe">IMPORTE</th></tr>
        </thead>
        <tbody>
        EOF; 
       /********/
       
       /********** */ 
        foreach( $Movi as $mo): 
            //con formato
            $f_MONTO= Helper::number_f( $mo->IMPORTE ); 
            $gooddate= Helper::beautyDate($mo->FECHA);
            $MOTIVO=  (is_null( $mo->ID_DEMA) )? "VARIOS": ("COD-EMP: ".$mo->COD_EMP);
            $html.= "<tr class=\"cuerpo\"> <td class=\"codigo\">{$mo->COD_GASTO}</td><td class=\"fecha\">{$gooddate}</td><td class=\"comprobante\">{$mo->NUMERO}</td><td class=\"detalle\">{$MOTIVO}</td><td  class=\"importe\">{$f_MONTO}</td></tr> ";
        endforeach;  


        $total= $Movi->sum("IMPORTE"); 
        //con formato
        $f_total= Helper::number_f( $total); 
    
        $html.= <<<EOF
        <tr class="pie"><td  class="codigo"></td><td class="fecha"></td><td class="comprobante">TOTAL</td><td class="detalle"></td><td class="importe">$f_total</td></tr> 
        </tbody></table>
        EOF;
         
        if( $tipo=="PRINT"){
            echo $html;
        }else{
            //echo $html;
            $tituloDocumento= "GASTOS-".date("d")."-".date("m")."-".date("yy")."-".rand();
            $pdf = new PDF(); 
            $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
            $pdf->generarHtml( $html);
            $pdf->generar();
        }

    }//End pdf format option
     

}//End reporte function
 



public function demandas($CI){
    $titular= Demandados::where("CI", $CI)->first();
    if( is_null( $titular)){
        return view("gastos.demanda_chooser", ['error'=> "NO SE REGISTRA ESE NUMERO DE CEDULA" ]);
    }else{
        $dato_titular=  $titular->TITULAR;
        $demanda=Demanda::select( 'IDNRO', 'COD_EMP', 'DEMANDA', 'BANCO', 'CTA_BANCO')->where("CI",$CI)->get();
        return view("gastos.demanda_chooser", ['demandas'=> $demanda, 'TITULAR'=> $dato_titular ]);
    }
 
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




public function asignarCodigoGasto(){
   
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $reg=Gastos::get();
    foreach( $reg as $item){
        $desc= $item->CODIGO;
        $idnro=Codigo_gasto::where("CODIGO", $desc)->first();
        if( !is_null($idnro) ){
            $id_=$idnro->IDNRO;
            $item->CODIGO= $id_; 
            $item->save();
        }
    }
}


}
