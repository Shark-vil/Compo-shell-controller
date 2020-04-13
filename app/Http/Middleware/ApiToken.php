<?php

namespace App\Http\Middleware;

use Closure;
//use Auth;
//use Illuminate\Support\Facades\Auth;
use App\UserToken;
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
        /*
        if (!empty(config()->get('app.apiSecretToken')) && $request->token == config()->get('app.apiSecretToken')) {
            return $next($request);
        }
        */

        if (auth()->check() && $request->token == UserToken::where('user_id', auth()->user()->id)->first()->token) {
            return $next($request);
        }
        
        $PublicToken = PublicToken::where('token', $request->token)->first();
        
        if ($PublicToken && ($PublicToken->eternal == 1 || ($PublicToken->active == 1 && $PublicToken->dateTime > date("Y-m-d h:i:s")))) {
            if ($request->token == $PublicToken->token) {
                return $next($request);
            }
        }
        
        return response(['success' => false, 'content' => 'Bad token.' . $request->token], 503);
    }
}
