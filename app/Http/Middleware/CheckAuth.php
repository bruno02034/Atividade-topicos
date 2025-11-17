<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->get('logged_in')) {
           return redirect()->route('login')->with('error','Faça login para continuar.');
        }
        return $next($request);
    }
}

