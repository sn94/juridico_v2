<?php

namespace App\Http\Middleware;

use Closure;

class ProveedorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */




  public function handle($request, Closure $next)
  {
    if (session("provider")) {
      return $next($request);
    } else {

      $permitidas = ["admin\/sign-in", "admin\/sign-out"];

      $permitir = false;
      foreach ($permitidas as $ruta) :
        if (preg_match("/$ruta/", $request->path())) {
          $permitir = true;
          break;
        }
      endforeach;
      if ($permitir)
        return $next($request); //dejar pasar
      else
        return redirect("denegado");
    }
  }
  
}
