<?php

namespace App\Services;

use App\Server;
use App\User;
use App\PublicToken;
use App\UserToken;

use Illuminate\Http\Request;

class TokenControl {

    public function GetUserToken()
    {
        if (auth()->check()) {
            return UserToken::where('user_id', auth()->user()->id)->first()->token;
        }

        return null;
    }

    public function GetUserByRequest(Request $request)
    {
        $user_id = null;

        if ($request->user_id) {
            $user_id = $request->user_id;
        } else {
            $userToken = UserToken::where('token', $request->token)->first();
            if ($userToken) {
                $user_id = $userToken->user_id;
            } else {
                $publicToken = PublicToken::where('token', $request->token)->first();
                if ($publicToken) {
                    $user_id = $publicToken->user_id;
                }
            }
        }

        if ($user_id == null)
            return null;

        return User::where('id', $user_id);
    }

    /**
     * Возвращает пользователя по токену.
     *
     * @param string  $token
     * @return \App\User
     */
    public function GetUserByToken($token)
    {
        $user_id = null;

        $userToken = UserToken::where('token', $token)->first();
        if ($userToken) {
            $user_id = $userToken->user_id;
        } else {
            $publicToken = PublicToken::where('token', $token)->first();
            if ($publicToken) {
                $user_id = $publicToken->user_id;
            }
        }

        if ($user_id == null)
            return null;

        return User::where('id', $user_id);
    }

    public function UpdateUserToken($user)
    {
        $data = [];
        $data['user_id'] = $user->id;
        $data['token'] = md5($user->id . $user->name . date('YmdHis'));
        UserToken::where('user_id', $user->id)->update($data);
        return $data['token'];
    }

}