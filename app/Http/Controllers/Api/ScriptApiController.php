<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Script;

use Illuminate\Http\Request;

class ScriptApiController extends Controller
{
    public function get(Request $request)
    {
        if (!$request->id) {
            return ['success' => true, 'content' => Script::all()];
        }
        return ['success' => true, 'content' => Script::where('id', $request->id)->first()];
    }

    public function post(Request $request)
    {
        if ($request->server_id && $request->description && $request->command) {
            $LastId = Script::insertGetId($request->except('token', '_token'));

            return ['success' => true, 'content' => Script::where('id', $LastId)->first()];
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function put(Request $request)
    {
        if ($request->id) {
            if ($request->server_id || $request->description || $request->command) {
                Script::where('id', $request->id)->update($request->except('token', '_token'));
                return ['success' => true, 'content' => Script::where('id', $request->id)->first()];
            }
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function delete(Request $request)
    {        
        if ($request->id) {
            $TempData = Script::where('id', $request->id)->first();
            
            if (!$TempData) {
                return ['success' => false, 'content' => 'There is no such entry.']; 
            }

            Script::where('id', $request->id)->delete();
            return ['success' => true, 'content' => $TempData]; 
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }
}