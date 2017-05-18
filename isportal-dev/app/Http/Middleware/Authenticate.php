<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        session_start();

        if(isset($_SESSION["student"])){

            try{

                $ist_id = \FenixEdu::getSingleton()->getIstId();

                if($ist_id != $_SESSION["student"]->ist_id){
                    unset($_SESSION["student"]);
                    return redirect("/login");
                }

            }
            catch (Exception $e){
                unset($_SESSION["student"]);
                return redirect("/login");
            }


        }


        return $next($request);
        
    }

}
