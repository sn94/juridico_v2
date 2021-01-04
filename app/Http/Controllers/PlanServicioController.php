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

    public function index()
    {
        $dato = Plan_servicio::orderBy('IDNRO', 'desc')->paginate(20);
        if (request()->ajax()) {
            $dato = Plan_servicio::orderBy('IDNRO', 'desc')->paginate(20);
            return view("modulo_admin.planes.grilla", ['lista' =>   $dato]);
        } else {
            $dato = Plan_servicio::orderBy('IDNRO', 'desc')->paginate(20);
            return view(
                    "modulo_admin.planes.index",
                    ["lista" =>  $dato]
                );
        }
    }


 

    public function create(Request $request)
    {

        if ($request->isMethod("POST")) {
            $cod_gasto  = new Plan_servicio();

            //avanzar
            $datoReci = $request->input();
            $datoReci['PRECIO'] =  Helper::cleanNumber($datoReci['PRECIO']);
            $cod_gasto->fill($datoReci);
            $cod_gasto->save();
            return response()->json(  array("ok" =>   "SE HA CREADO UN PLAN") ) ;
        } else {
            return view("modulo_admin.planes.create");
        }
    }

     


    
    public function update(Request $request,$id=""){
        
        if(  $request->isMethod("PUT")  ){
            $cod_gasto= Plan_servicio::find(  $request->input("IDNRO" )  );
                 //avanzar
                 $datoReci= $request->input();
                 $datoReci['PRECIO']=  Helper::cleanNumber(   $datoReci['PRECIO'] ) ;
                 $cod_gasto->fill( $datoReci );
                 $cod_gasto->save();
                 return response()->json( array("ok"=>  "DATOS DE PLAN EDITADO" ) );
        }else{
             
                $cod_gasto= Plan_servicio::find( $id);
                return view("modulo_admin.planes.update", 
                  [   'DATO'=>$cod_gasto ]);
            
        }
    }


    public function show($idnro){
        $plan=  Plan_servicio::find($idnro);
        if(  is_null(  $plan))
        return response()->json(  ['error'=>  "No existe el ID $idnro" ] );
        else  return response()->json(  ['ok'=>   $plan ] ); 
    }




    public function borrar($idnro){
        if( Plan_servicio::find($idnro)->delete())
        echo json_encode( array("ok"=> "BORRADO" )  );
        else
        echo json_encode( array("error"=> "NO SE PUDO BORRAR" )  );
    }


 
  


 
  

 

 




}
