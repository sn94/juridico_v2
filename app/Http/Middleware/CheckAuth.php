<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


     //a partir del prefijo unico, del nick se deduce cual es la base de datos a conectar

    private function obtenerConexion( $keepDefaultSetting=  false ){
      if(  $keepDefaultSetting)  return;
      $systemid=  session("system");  
      $DataBaseName= "cli_".$systemid;
      $configDb = array(
          'driver' => 'mysql',
          'host' => 'localhost',
          'database' =>  $DataBaseName,
          'username' => 'root',
          'password' => '',
          'charset' => 'utf8',
          'prefix' => '',
      );
      Config::set('database.connections.mysql', $configDb);
     //$conexionSQL = DB::connection('mysql');
     return $systemid;
  }



    public function handle($request, Closure $next)
    {
         if ($request->session()->has('nick')) {
           if(  $request->session()->has('provider')  ){
              $this->obtenerConexion(  true );
           }else{
            $this->obtenerConexion();
           }
         
           return $next($request);//dejar pasar
         }else{
            if( $request->path() == "signin" ||  $request->path() == "signin/p" || 
             $request->path() == "solicitar-suscripcion" ||  $request->path()=="paso1_suscriptor"
             ||   $request->path() == "suscripcion" ){
                return $next($request);//dejar pasar
            }else {
                if(  preg_match( "/recovery-password/" ,  $request->path())  > 0) { 
                  return $next($request);//dejar pasar
                }else {
                  if(  preg_match( "/p\//" ,  $request->path())  > 0)
                  return redirect('signin/p'); 
                  else 
                  return redirect('signin'); 
                
                }
            
            }
         }
        
    }
}
