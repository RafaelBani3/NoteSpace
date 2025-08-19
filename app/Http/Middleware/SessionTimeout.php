<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;


class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $timeout = 30 * 60; // 30 menit

        if (!Session::has('lastActivityTime')) {
            Session::put('lastActivityTime', time());
        } elseif (time() - Session::get('lastActivityTime') > $timeout) {
            Session::forget('lastActivityTime');
            // auth()->logout();
            return redirect()->route('login')->with('warning', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        Session::put('lastActivityTime', time());
        return $next($request);
        
        return $next($request);
    }
}
