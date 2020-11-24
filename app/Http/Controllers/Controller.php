<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function defaultConexion( ){
      
        $configDb = array(
            'driver' => 'mysql',
            'host' => env("DB_HOST"),
            'database' =>  env("DB_DATABASE"),
            'username' =>  env("DB_USERNAME"),
            'password' => env("DB_PASSWORD"),
            'charset' => 'utf8',
            'prefix' => '',
        );
     
        Config::set('database.connections.principal', $configDb);
       //$conexionSQL = DB::connection('mysql'); 
    }
    public function obtenerConexion( $USER="" ){
       
        $id_sys= ( explode("_",  $USER))[0];


        $systemid=  (  $USER!= "" ) ?  $id_sys :   session("system");  
        $DataBaseName= "cli_".$systemid;
        $configDb = array(
            'driver' => 'mysql',
            'host' =>  env("DB_HOST"),
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




  
}
