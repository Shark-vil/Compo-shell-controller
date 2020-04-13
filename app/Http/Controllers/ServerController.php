<?php

namespace App\Http\Controllers;

use App\Server;
use App\Log;
use Illuminate\Http\Request;
use Auth;
use App\UserToken;

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
        return view('server\index', ['servers' => Server::all(), 'token' => $this->GetUserToken()]);
    }

    public function console(int $id)
    {
        return view('server\console', ['server' => Server::where('id', $id)->first(), 'token' => $this->GetUserToken()]);
    }

    public function add()
    {
        return view('server\add', ['token' => $this->GetUserToken()]);
    }

    public function delete(int $id) {
        $server = Server::where('id', $id);
        if ($server->first()) {
            $server->delete();
        }

        $this->index();
    }

    public function edit(int $id) {
        $server = Server::where('id', $id)->first();

        if ($server)
            return view('server\edit', ['server' => $server,'token' => $this->GetUserToken()]);

        $this->index();
    }

    public function logs(int $id) {
        $logs = Log::where('server_id', $id)->select('date')->groupBy('date')->get();

        if ($logs)
            return view('server\logs', ['id' => $id, 'logs' => $logs]);

        $this->index();
    }

    public function logsDate(int $id, string $date)
    {
        $logs = Log::where('date', $date)->get();

        if ($logs)
            return view('server\logs-view', ['id' => $id, 'logs' => $logs]);

        $this->index();
    }

    public function scripts()
    {
        
    }
}
