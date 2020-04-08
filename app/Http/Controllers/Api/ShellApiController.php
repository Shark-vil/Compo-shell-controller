<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Servers;

use Illuminate\Http\Request;

class ServersApiController extends Controller
{
    public function post_exec(Request $request)
    {
        if ($request->ip && $request->user && $request->password && $request->command) {
            if ($request->ip == config()->get('app.serverIp')
                && $request->user == config()->get('app.serverUser')
                && password_verify(config()->get('app.serverPassword'), $request->password)
            ){
                shell_exec('sudo -u ' . $request->user . ' cd ~;' . $request->command);
            }
        }
    }
}