<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Lord
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

        // Redirect If Not Lord
        if(!Auth::user()->lord) {
            return redirect()->route('lord.apply');
        }

        // Let Him Pass
        return $next($request);

    }
}
