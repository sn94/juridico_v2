<?php

namespace App\Http\Middleware;

use Closure;

class OperadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function rutas_permitidas_sin_abogado($request)
    {
      if(  $request->session()->has("abogado"))  return true; 
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
        if (session("tipo") == "O" ||   session("tipo") == "S" ||   session("tipo") == "SA") {

             return $next($request);
            
        } else
            return redirect("denegado");
    }
}
