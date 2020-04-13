<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\PublicToken;
use App\User;

use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    public function post(Request $request)
    {
        $User = User::where('id', $request->user_id)->first();
        $UserId = $User->id;

        $ActiveTokens = PublicToken::where('user_id', $UserId)->get();

        if ($ActiveTokens) {
            foreach($ActiveTokens as $ActiveToken) {
                PublicToken::where('id', $ActiveToken->id)->delete();
            }
        }

        $Data = [];
        $Data['user_id'] = $UserId;
        $Data['token'] = md5($User->id . $User->name . date('Ymdhis'));
        $Data['eternal'] = $request->eternal;
        $Data['lives_time'] = ($request->lives_time) ? date('Y-m-d h:i:s', strtotime($request->lives_time)) : date('Y-m-d h:i:s');

        $LastId = PublicToken::insertGetId($Data);

        return ['success' => true, 'content' => PublicToken::where('id', $LastId)->first()];
    }

    public function delete(Request $request)
    {        
        if ($request->user_id) {
            $ActiveTokens = PublicToken::where('user_id', $request->user_id)->get();

            if ($ActiveTokens) {
                foreach($ActiveTokens as $ActiveToken) {
                    PublicToken::where('id', $ActiveToken->id)->delete();
                }
            }

            return ['success' => true, 'content' => '']; 
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }
}