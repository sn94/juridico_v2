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


    private function obtenerConexion($keepDefaultSetting =  false)
    {
        if ($keepDefaultSetting)  return;
        $systemid =  session("system");
        $DataBaseName = "cli_" . $systemid;
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


    public function rutas_permitidas_sin_abogado($request)
    {
        if(  $request->session()->has('abogado')  ){
            $this->obtenerConexion(); return true;//dejar pasar
          } 


       
        $permitidas = ["\/", "abogados", "user", "signout",  "denegado"];
        $permitir = false;
        foreach ($permitidas as $ruta) :
            if (preg_match("/$ruta/", $request->path())) {
                $permitir = true;
                break;
            }
        endforeach;
        return $permitir;
    }


    public function handle($request, Closure $next)
    {

        if (session("tipo") == "SA") {
            if (!$this->rutas_permitidas_sin_abogado($request))
                redirect("/");
            else
                return $next($request);
        } else {
            return redirect("denegado");
        }
    }
}
