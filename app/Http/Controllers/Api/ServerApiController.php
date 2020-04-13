<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Server;

use Illuminate\Http\Request;

class ServerApiController extends Controller
{
    public function get(Request $request)
    {
        if (!$request->id) {
            return ['success' => true, 'content' => Server::all()];
        }
        return ['success' => true, 'content' => Server::where('id', $request->id)->first()];
    }

    public function post(Request $request)
    {
        if ($request->ip && $request->port && $request->user && $request->password) {
            $LastId = Server::insertGetId($request->except('token', '_token'));

            return ['success' => true, 'content' => Server::where('id', $LastId)->first()];
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function put(Request $request)
    {
        if ($request->id) {
            if ($request->ip || $request->port || $request->user || $request->password) {
                Server::where('id', $request->id)->update($request->except('token', '_token'));
                return ['success' => true, 'content' => Server::where('id', $request->id)->first()];
            }
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function delete(Request $request)
    {        
        if ($request->id) {
            $TempData = Server::where('id', $request->id)->first();
            
            if (!$TempData) {
                return ['success' => false, 'content' => 'There is no such entry.']; 
            }

            Server::where('id', $request->id)->delete();
            return ['success' => true, 'content' => $TempData]; 
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }
}