<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use Auth;
use App\UserToken;
use TokenControl;

class ServerController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('server\index', ['servers' => Server::all(), 'token' => TokenControl::GetUserToken()]);
    }

    public function console(int $id)
    {
        return view('server\console', ['id' => $id, 'server' => Server::where('id', $id)->first(), 'token' => TokenControl::GetUserToken(), 'user_id' => auth()->user()->id]);
    }

    public function add()
    {
        return view('server\add', ['token' => TokenControl::GetUserToken()]);
    }

    public function delete(int $id) {
        $server = Server::where('id', $id);
        if ($server->first()) {
            $server->delete();
        }

        return redirect()->route('server');
    }

    public function edit(int $id) {
        $server = Server::where('id', $id)->first();

        if ($server)
            return view('server\edit', ['id' => $id, 'server' => $server,'token' => TokenControl::GetUserToken()]);

        return redirect()->route('server');
    }
}
