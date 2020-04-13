<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Log;

use Illuminate\Http\Request;

class ShellApiController extends Controller
{
    protected $session;

    public function post_exec(Request $request)
    {
        if ($request->ip && $request->user && $request->password && $request->command) {
            $this->session = ssh2_connect($request->ip, $request->port);

            if ($this->session) {
                ssh2_auth_password($this->session, $request->user, $request->password);
                $stream = ssh2_exec($this->session,  $request->command);
                stream_set_blocking($stream, true);
                $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                $result = stream_get_contents($stream_out);

                $Data = [];
                $Data['server_id'] = $request->id;
                $Data['date'] = date("Y-m-d");
                $Data['time'] = date("H:i:s");
                $Data['command'] = $request->command;
                $Data['result'] = $result;

                Log::insert($Data);

                return ['success' => true, 'content' => $result];
            }

            return ['success' => false, 'content' => 'There is no connection to the server.'];
        }

        return ['success' => false, 'content' => 'Invalid send options specified.'];
    }

    public function __destruct() {
        ssh2_disconnect($this->session);
    }
}