<?php

namespace App\Http\Controllers;

use App\Servers;
use Illuminate\Http\Request;
use Auth;
use App\UserToken;

class ServersController extends Controller
{
    protected $UserToken;

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
        $this->UserToken = UserToken::where('user_id', Auth::user()->id)->first()->token;
        return $this->UserToken;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('servers\index', ['servers' => Servers::all(), 'token' => $this->GetUserToken()]);
    }

    public function console(int $id)
    {
        return view('servers\console', ['server' => Servers::where('id', $id)->first(), 'token' => $this->GetUserToken()]);
    }

    public function add()
    {
        return view('servers\add', ['token' => $this->GetUserToken()]);
    }

    public function delete(int $id) {
        $server = Servers::where('id', $id);
        if ($server->first()) {
            $server->delete();
        }

        $this->index();
    }
}
