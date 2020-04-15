<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PublicToken;
use App\UserToken;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $userToken = $user->public_token()->first();
        $content = ($userToken) ? $userToken->token : 'Токен не создан';

        return view('profile\index', ['user' => $user, 'token' => $content]);
    }

    public function settings()
    {
        $user = auth()->user();

        return view('profile\settings', ['user' => $user, 'token' => $user->user_token()->first()->token]);
    }

    public function settingsToken()
    {
        $user = auth()->user();

        return view('profile\settings-token', ['user' => $user, 'token' => $user->user_token()->first()->token]);
    }
}
