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

class AdminWelcomeController extends Controller
{
    

    public function __construct()
    { 

        date_default_timezone_set("America/Asuncion");
      
    }
   

  
 



    public function index( Request $request){

         
        $this->defaultConexion();   
    return view("modulo_admin.index");
    }

 


}