<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Http\Controllers\Controller;
use App\ODemanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Parametros;
use Illuminate\Http\Client\Request as ClientRequest;

class ParamController extends Controller
{


    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }




    public function index()
    {

        $this->obtenerConexion();
        $params = Parametros::first();
        return view('parametros.index',  ["DATO" => $params]);
    }





    public function agregar(Request $request)
    {

        $this->obtenerConexion();
        if ( $request->isMethod("POST")) { //hay datos 
            //Quitar el campo _token
            $Params =  $request->input();
            $Params['ABOGADO']= session("abogado");
            //Devuelve todo elemento de Params que no este presente en el segundo argumento
             

            DB::beginTransaction();
            try {
                //VERIFICAR SI YA HAY UN REGISTRO
                $reg=  Parametros::where("ABOGADO", session("abogado"))->first();
                if (  !is_null( $reg)) {
                    //Actualizar
                    $rw = Parametros::first()->update($Params);
                    echo json_encode(array('ok' =>  "ACTUALIZADO"));
                } else {
                    $r = new Parametros();
                    $r->fill($Params);
                    $r->save();
                    echo json_encode(array('ok' =>  "GUARDADO"));
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                echo json_encode(array('error' => "Hubo un error al guardar uno de los datos<br>$e"));
            }
        } else {
            if (Parametros::get() > 0)  return view('parametros.index',  ['DATO' =>  Parametros::first()]);
            else  return view('parametros.index');
        }
        /** */
    }



    public  function get_param($nombre)
    {

        $this->obtenerConexion();
        return Parametros::select($nombre)->first()->{$nombre};
    }

 

 


}