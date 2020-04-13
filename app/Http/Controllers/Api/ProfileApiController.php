<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TokenControl;
use App\User;

class ProfileApiController extends Controller
{
    public function put(Request $request)
    {
        if ($request->name) {
            $user = TokenControl::GetUserByRequest($request);
            
            if ($user->first()) {
                $Data = [];
                $Data['name'] = $request->name;
                $user->update($Data);

                return ['success' => true, 'content' => User::where('id', $user->first()->id)->first()];
            }
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }
}
