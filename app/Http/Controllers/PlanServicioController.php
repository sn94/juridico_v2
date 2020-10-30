<?php

namespace App\Http\Controllers;
 
use App\Codigo_gasto;
use App\Demanda;
use App\Demandados;
use App\Gastos;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\pdf_gen\PDF;
use App\Plan_servicio;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class PlanServicioController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  
    public function index(){
        $dato= Plan_servicio::orderBy('IDNRO', 'desc')->paginate(20); 
       if ( request()->ajax() )
       return view("0provider.planes.grilla", ['lista'=>   $dato] );
       else
      { $dato= Plan_servicio::orderBy('IDNRO', 'desc')->paginate(20); 
       return view("0provider.planes.index",
        ["lista"=>  $dato,  "url_agregar"=> url("p/planes-servicio/nuevo"), 
        "ruta_listado"=> url("p/planes-servicio"),  "breadcrumbcolor"=>"#fdc673 !important;"] );}
       
    }




    public function  listar(){
        $dato= Plan_servicio::orderBy('IDNRO', 'desc')->get();
        return response()->json(  $dato);
    }

    public function cargar(Request $request, $ope= "A", $id=""){
        
        if(  $request->isMethod("POST")  ){
            $cod_gasto=null;
            if( $ope == "A"){   $cod_gasto= new Plan_servicio();    }  
            if( $ope == "M"){
                //cASO EDICION
                $cod_gasto=Plan_servicio::find(  $request->input("IDNRO" )  );
            }//FIN EDICION    

                 //avanzar
                 $datoReci= $request->input();
                 $datoReci['PRECIO']=  Helper::cleanNumber(   $datoReci['PRECIO'] ) ;
                 $cod_gasto->fill( $datoReci );
                 $cod_gasto->save();
                 echo json_encode( array("ok"=> $ope=="A" ? "SE HA CREADO UN PLAN" :  "DATOS DE PLAN EDITADO" )  );
          

        }else{
            //Preparar parametros 
            $ruta=   $ope == "A" ? url("p/planes-servicio/nuevo")  :  url("p/planes-servicio/M");
            if( $ope == "A")    
            return view("0provider.planes.form",  
             ['OPERACION'=> $ope,   'RUTA'=> $ruta ]);
            if( $ope == "M") {
                $cod_gasto= Plan_servicio::find( $id);
                return view("0provider.planes.form", 
                  ['OPERACION'=> $ope,   'RUTA'=> $ruta,  'DATO'=>$cod_gasto ]);
            }
        }
    }

     
    

    public function borrar($idnro){
        if( Plan_servicio::find($idnro)->delete())
        echo json_encode( array("ok"=> "BORRADO" )  );
        else
        echo json_encode( array("error"=> "NO SE PUDO BORRAR" )  );
    }


 
  


 
  

 

 




}
