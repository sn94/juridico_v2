<?php

namespace App\Http\Controllers;

use App\Abogados;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\pdf_gen\PDF;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB; 

class AbogadoController extends Controller
{
    

    public function __construct()
    {
       
        date_default_timezone_set("America/Asuncion");
    }
  


    private function obtenerConexion( $keepDefaultSetting=  false ){
        if(  $keepDefaultSetting)  return;
        $systemid=  session("system");  
        $DataBaseName= "cli_".$systemid;
        $configDb = array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' =>  $DataBaseName,
            'username' =>  env("DB_USERNAME"),
            'password' => env("DB_PASSWORD"),
            'charset' => 'utf8',
            'prefix' => '',
        );
     
        Config::set('database.connections.mysql', $configDb);
       //$conexionSQL = DB::connection('mysql');
       return $systemid;
    }



    public function index(){
     
        $this->obtenerConexion();

        $cantidad=  Abogados::count();

        if( $cantidad <= 0){
            if(  request()->ajax())  return view("abogado.grilla", ["sin_abogados"=> true]);
            else   return view("abogado.index", ["sin_abogados"=> true]);
        }else{
            $abogados= Abogados::paginate(10);
            if(  request()->ajax())  return view("abogado.grilla",  ['abogados'=>  $abogados  ]);
            else   return view("abogado.index",  ['abogados'=>  $abogados  ]);
        }
     
       
    }




    public function select_cod_abogado(  $codigo ){
        //Realmente existe?
        $this->obtenerConexion();
        $abo= Abogados::find(  $codigo);
        if( is_null( $abo) )
        { 
           return  response()->json(  ["error"=> "El código que ingresó no existe"  ] );
           // return view("layouts.error",  ["error"=> "El código que ingresó no existe"  ]);
        }
        else
       { session(['abogado' => $codigo]);
        return redirect(  url("/") );} 
    }


    public function cargar( Request $request, $id=0){
        $this->obtenerConexion();
        if(   $request->isMethod("POST"))  {//hay datos 
            //Quitar el campo _token
            $Params=  $request->input();  
             DB::beginTransaction();
            try{
                
                $r= null;
                if(  $id == 0){  
                    $r= new Abogados();
                }
                else   $r= Abogados::find( $request->input("IDNRO") ); 
                 $r->fill(  $Params  );  
                 $r->save();
                 echo json_encode( array('idnro'=>  $r->IDNRO  ));    
                DB::commit();
           
            } catch (\Exception $e) {
                DB::rollback();
                echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
            }   
        }
        else  {   
            if( $id == 0)
            {
                if( request()->ajax())
                return view("abogado.form",  ["OPERACION"=>"A"] );
                else 
               { $us= Abogados::paginate(10);
                return view('abogado.create' , ['abogados'=> $us]);
                }  
            }
            else{
                $dato= Abogados::find( $id );
                if( request()->ajax())
                return view("abogado.form",  [ "IDNRO"=> $id, "DATO"=> $dato , "OPERACION"=>"M"]);
                else 
               { $us= Abogados::paginate(10);
                return view('abogado.create' , ['abogados'=> $us]);
                }  
                
            }
           
         }   
     }




     public function delete( $id){
         $this->obtenerConexion();
        if(  Abogados::find($id)->delete() ) echo json_encode( array('ok'=>  "BORRADO"  ) );
        else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );
     
     }


}