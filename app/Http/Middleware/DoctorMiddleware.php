<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware
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
        if (Auth::user())
        {
            if (Auth::user()->roles->first()->name == "doctor")
            {
                return $next($request);
            }

        }
        return redirect(url('/'));
    }
}
