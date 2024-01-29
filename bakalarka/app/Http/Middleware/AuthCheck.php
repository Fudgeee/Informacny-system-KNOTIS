<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        dd($request);
        if(!session()->has('loginId')){
            $lastActivity = session('loginId' . '_last_activity', 0);
            $sessionLifetime = config('session.lifetime') * 60; // V sekundách

            if (time() - $lastActivity > $sessionLifetime) {
                // Relácia vypršala, odhlásime užívateľa
                auth()->logout();
                return redirect('login')->with('fail', 'Platnosť relácie vypršala. Prosím, prihláste sa znovu.');
            }
        }
        return $next($request);
    }
}
