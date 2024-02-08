<?php

namespace App\Http\Middleware;

use Closure;
use CRUDBooster;
class FrontMiddleware
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
        
        if (CRUDBooster::myId() == '') {
            // $url = url('/login');
            return redirect()->route('login')->with('message', 'Please login first !');
        }
        return $next($request);
    }
}
