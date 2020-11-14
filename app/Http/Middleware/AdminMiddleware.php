<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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

        if( session("tipo") == "S"  ||   session("tipo") == "SA")

     {  
          if( (session("tipo") == "S" )  && (preg_match("/abogados/",  $request->path() )  > 0))
        return redirect("denegado");
        else
          return $next($request);
        }
           
        else
        { 
            return redirect("denegado");
        }
    }
}
