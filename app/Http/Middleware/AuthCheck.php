<?php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Auth\Middleware\Authenticate;
//use Auth;

class AuthCheck
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
        if (!auth()->check()) {
            return response(['success' => false, 'content' => 'You\'re not authorized.'], 503);
        }
        
        return $next($request);
    }
}
