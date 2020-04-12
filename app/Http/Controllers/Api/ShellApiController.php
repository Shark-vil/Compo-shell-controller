<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Servers;

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

                return ['success' => true, 'content' => stream_get_contents($stream_out)];
            }
        }

        return ['success' => false, 'content' => 'Not connected to server.'];
    }

    public function __destruct() {
        ssh2_disconnect($this->session);
    }
}