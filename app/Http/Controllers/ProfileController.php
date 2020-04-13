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

    protected function GetUserToken()
    {
        $this->UserToken = UserToken::where('user_id', auth()->user()->id)->first()->token;
        return $this->UserToken;
    }

    public function index()
    {
        $user = auth()->user();
        $userToken = PublicToken::where('user_id', $user->id)->first();

        return view('profile\index', ['user' => $user, 'token' => ($userToken) ? $userToken->token : 'Токен не создан']);
    }

    public function settings()
    {
        $user = auth()->user();
        return view('profile\settings', ['user' => $user, 'token' => $this->GetUserToken()]);
    }

    public function settingsToken()
    {
        $user = auth()->user();
        return view('profile\settings-token', ['user' => $user, 'token' => $this->GetUserToken()]);
    }
}
