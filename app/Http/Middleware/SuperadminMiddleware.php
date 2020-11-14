<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class SuperadminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     
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

    

    public function handle($request, Closure $next)
    {
        
        if( session("tipo") == "SA"  )
        return $next($request);
/*
          if(  $request->session()->has('abogado')  ){
              $this->obtenerConexion(); return $next($request);//dejar pasar
            }else{
              //control codigo abogado
             //(preg_match("/abogados/",  $request->path() )  > 0) 
              if(  $request->path() =="" ||  preg_match("/abogados/",  $request->path() )  > 0 ||  (preg_match("/user/",  $request->path() )  > 0)) 
              return redirect('abogados'); 
              else return $next($request);//dejar pasar
            }
*/

      //  return $next($request);
        else
        { 
            return redirect("denegado");
        }
    }
}
