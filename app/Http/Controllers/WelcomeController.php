<?php

namespace App\Http\Controllers;

use App\CuentaJudicial;
use App\Demanda;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Demandados;
use App\Liquidacion;
use App\Notificacion;
use App\Observacion;
use App\Parametros;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Error\Notice;

class WelcomeController extends Controller
{
    

    public function __construct()
    { 

        date_default_timezone_set("America/Asuncion");
      
    }
   

  
 



    public function index( Request $request){

        if( ! $request->session()->has("abogado")) {

            if( session("tipo")=="SA")
            return redirect('abogados');
            else
            return view("welcome_sin_contexto");
        }
        
        $this->obtenerConexion();   
        
        if ( session('tipo') == "S"  || session("tipo")== "SA"  ){
            $Parametros= Parametros::first();
             
            if(  is_null(  $Parametros)  ||  $Parametros->SHOW_COUNTERS == "S"){
            $demanda= Demanda::sum("DEMANDA");  //Total monto demandas
            //Obtencion de saldos
            $judiob= new JudicialController();
            $judi= $judiob->saldos_C_y_L_lite();
            $saldo_c= $judi["saldo_capital"];
            $saldo_l= $judi["saldo_liquida"];
            
            $demandados= Demandados::count();//numero de demandados
            $demandas_nro=  Demanda::count();//numero de juiciso
            $liquidacion= Notificacion::sum("IMPORT_LIQUI");
            // "saldo_judi"=> intval($judi['saldo_judi']) < 0 ? "0": $judi['saldo_judi'] ,//Saldos
            return view('welcome',  [
            "demanda"=>$demanda, //Demandas 
           "demandados"=> $demandados,
           "total_demandas"=> $demandas_nro,
            "saldo_c"=> $saldo_c,//Saldo: Total de ext. de capital
            "saldo_l"=> $saldo_l, //Saldo: Total de ext. de Liquidacion
            "liquidacion"=> $liquidacion
            ,"show"=>"S"
            ]);
            }else{
                return view('welcome', ["show"=>"N"]);
            }
        }else{
            return view('welcome', ["show"=>"N"]);
           //return redirect("/");
        }
       

    }


  
  

    public function unauthorized(){
        return view("layouts.unauthorized");
    }


}