<?php

namespace App\Http\Middleware;

use Closure;

class SessionAuth
{

    public function handle($request, Closure $next)
    {
        if (!$request->session()->exists('USERID')) {
            // user value cannot be found in session
            return redirect('/');
        }

        return $next($request);
    }

}

