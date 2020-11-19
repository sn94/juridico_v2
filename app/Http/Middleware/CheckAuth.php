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
          'username' =>  env("DB_USERNAME"),
          'password' => env("DB_PASSWORD"),
          'charset' => 'utf8',
          'prefix' => '',
          
        );
      Config::set('database.connections.mysql', $configDb);
     //$conexionSQL = DB::connection('mysql');
     return $systemid;
  }



  private function rutas_permitidas(   $request  ){
//rutas permitidas sin autenticacion
    $permitidas= [ "signin", "signin\/p", "solicitar-suscripcion", "paso1_suscriptor", "suscripcion", "usuario-existe",
  "recovery-password", "reset-password"];
  $permitir= false;
    foreach($permitidas as $ruta):
      if(        preg_match("/$ruta/", $request->path() ) ){ $permitir= true; break; }
    endforeach;
    return $permitir;
  }







    public function handle($request, Closure $next)
    {

     

         if ($request->session()->has('nick')) {
           if(  $request->session()->has('provider')  ){
              $this->obtenerConexion(  true ); return $next($request);//dejar pasar
           }else{
             
            if(  $request->session()->has('abogado')  ){
              $this->obtenerConexion(); return $next($request);//dejar pasar
            }else{
              //control codigo abogado
              if(  $request->path()=="/" || (preg_match("/abogados/",  $request->path() )  > 0)  ||  (preg_match("/user/",  $request->path() )  > 0)  || (preg_match("/signout/",  $request->path() )  > 0)  ||   (preg_match("/denegado/",  $request->path() )  > 0) ) 
              {
                
                return $next($request);//dejar pasar 

              }
              else
              {
                if( session("tipo")=="SA")
                return redirect('abogados');
                else redirect("/");
               }
            }

           // return $next($request);//dejar pasar
           }
           
         }else{

          if( $this->rutas_permitidas( $request) )     return $next($request);//dejar pasar
          else{
            if( preg_match( "/p\//" ,  $request->path())  > 0) return redirect('signin/p'); 
            else   return redirect('signin'); 
          }

         }
        
    }
}
