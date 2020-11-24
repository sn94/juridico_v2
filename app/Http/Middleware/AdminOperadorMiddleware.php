<?php

namespace App\Http\Middleware;

use Closure;

class AdminOperadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function rutas_permitidas_sin_abogado( $request){
        if(  $request->session()->has("abogado"))  return true; 
        $permitidas= ["\/", "abogados", "user", "signout",  "denegado"];
        $permitir= false;
        foreach($permitidas as $ruta):
          if(        preg_match("/$ruta/", $request->path() ) ){ $permitir= true; break; }
        endforeach;
        return $permitir;
      }
      

      

    public function handle($request, Closure $next)
    {
        if( session("tipo") == "SA"  ||session("tipo") == "S"  ||  session("tipo") == "O")
        {
              if( (session("tipo") == "S"  ||  session("tipo") == "O")  && (preg_match("/abogados/",  $request->path() )  > 0))
              return redirect("denegado");
              else{
                
                    if( ! $this->rutas_permitidas_sin_abogado( $request)  ) 
                   {return  redirect("/"); }
                    else
                   {  return $next($request);}
            
            }
        }
        else 
        return redirect("denegado");
    }
}
