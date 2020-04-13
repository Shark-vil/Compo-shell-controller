<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Script;
use TokenControl;

class ScriptController extends Controller
{
    public function index($server_id)
    {
        return view('scripts\index', ['server_id' => $server_id, 'scripts' => Script::where('server_id', $server_id)->get(), 'token' => TokenControl::GetUserToken()]);
    }

    public function add($server_id)
    {
        return view('scripts\add', ['server_id' => $server_id, 'token' => TokenControl::GetUserToken()]);
    }

    public function edit($server_id, $script_id)
    {
        return view('scripts\edit', ['server_id' => $server_id, 'script' => Script::where('id', $script_id)->first(), 'token' => TokenControl::GetUserToken()]);
    }
}
