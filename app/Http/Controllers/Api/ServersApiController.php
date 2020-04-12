<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Servers;

use Illuminate\Http\Request;

class ServersApiController extends Controller
{
    public function get(Request $request)
    {
        if (!$request->id) {
            return ['success' => true, 'content' => Servers::all()];
        }
        return ['success' => true, 'content' => Servers::where('id', $request->id)->first()];
    }

    public function post(Request $request)
    {
        if ($request->ip && $request->port && $request->user && $request->password) {
            $LastId = Servers::insertGetId($request->except('token', '_token'));
            return ['success' => true, 'content' => Servers::where('id', $LastId)->first()];
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function put(Request $request)
    {
        if ($request->id) {
            if ($request->ip || $request->port || $request->user || $request->password) {
                Servers::where('id', $request->id)->update($request->except('token', '_token'));
                return ['success' => true, 'content' => Servers::where('id', $request->id)->first()];
            }
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function delete(Request $request)
    {        
        if ($request->id) {
            $TempData = Servers::where('id', $request->id)->first();
            
            if (!$TempData) {
                return ['success' => false, 'content' => 'There is no such entry.']; 
            }

            Servers::where('id', $request->id)->delete();
            return ['success' => true, 'content' => $TempData]; 
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }
}