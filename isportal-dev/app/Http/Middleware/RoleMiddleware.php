<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($request->user() != null) {  //Verify if the request is from an login user
            if($request->user()->type == $role){
                return $next($request);
            }
            return redirect('/home');
        }
        return redirect('/login');
    }

}
