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



  private function rutas_permitidas_sin_auth(   $request  ){
//rutas permitidas sin autenticacion
    $permitidas= [ "signin", "signin\/p", "solicitar-suscripcion", "paso1_suscriptor", "suscripcion", "usuario-existe",
  "recovery-password", "reset-password",  "documentos\/download"];
  $permitir= false;
    foreach($permitidas as $ruta):
      if(        preg_match("/$ruta/", $request->path() ) ){ $permitir= true; break; }
    endforeach;
    return $permitir;
  }

  public function rutas_permitidas_sin_abogado($request)
  {
    if ($request->session()->has("abogado"))  return true;
    else {

      $permitidas = [ "abogados", "user", "signout",  "denegado"];
      $permitir = false;
      foreach ($permitidas as $ruta) :
        if (preg_match("/$ruta/", $request->path())) {

          $permitir = true;
          break;
        }

      endforeach;
      return $permitir;
    }
  }





  public function handle($request, Closure $next)
  {

    if (preg_match("/recibos-free/",  $request->path())  > 0)   return $next($request); //dejar pasar 

    if ($request->session()->has('nick')) {
      if ($request->session()->has('provider')) {
        $this->obtenerConexion(true);
        return $next($request); //dejar pasar
      } else {
        if ($this->rutas_permitidas_sin_abogado($request)) {
           return $next($request); //dejar pasar
        } else
          return  redirect("session-abogados");
      }
    } else {

      if ($this->rutas_permitidas_sin_auth($request))     return $next($request); //dejar pasar
      else {
        if (preg_match("/p\//",  $request->path())  > 0) return redirect('signin/p');
        else   return redirect('signin');
      }
    }
  }
}
