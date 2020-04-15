<?php

namespace App\Http\Middleware;

use Closure;
use App\PublicToken;

class ApiToken
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
        if (auth()->check() && auth()->user()->user_token()->first()) {
            return $next($request);
        }
        
        if ($request->token && $public_token = PublicToken::where('token', $request->token)->first()) {
            if ($public_token->eternal == 1 || ($public_token->active == 1 && $public_token->dateTime > date("Y-m-d h:i:s"))) {
                return $next($request);
            }
        }
        
        return response(['success' => false, 'content' => 'Bad token.' . $request->token], 503);
    }
}
