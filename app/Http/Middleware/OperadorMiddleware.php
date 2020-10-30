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
    public function handle($request, Closure $next)
    {
        if( session("tipo") == "O" ||   session("tipo") == "S")
        return $next($request);
        else
        return redirect("denegado");
    }
}
