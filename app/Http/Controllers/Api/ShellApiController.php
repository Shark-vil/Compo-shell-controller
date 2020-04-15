<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Log;
use App\Server;
use App\Script;
use TokenControl;

use Illuminate\Http\Request;

class ShellApiController extends Controller
{
    protected $session;

    private $ciphering = "AES-128-CTR";
    private $crypt_salt = '1234567891011121';

    public function post_exec(Request $request)
    {
        if ($request->ip && $request->user && $request->password && $request->command) {
            $this->session = ssh2_connect($request->ip, $request->port);

            if ($this->session) {
                $decryption_password = openssl_decrypt($request->password, $this->ciphering, openssl_digest($request->user, 'MD5', TRUE), 0, $this->crypt_salt);

                ssh2_auth_password($this->session, $request->user, $decryption_password);
                $stream = ssh2_exec($this->session,  $request->command);
                stream_set_blocking($stream, true);
                $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                $result = stream_get_contents($stream_out);

                $server = Server::where('ip', $request->ip)->where('port', $request->port)->first();

                $Data = [];
                $Data['user_id'] = TokenControl::GetUserByRequest($request)->first()->id;
                $Data['server_id'] = $server->id;
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

    public function post_script_exec(Request $request)
    {
        if ($request->id) {
            $script = Script::where('id', $request->id)->first();

            if ($script) {
                $server = Server::where('id', $script->server_id)->first();

                $this->session = ssh2_connect($server->ip, $server->port);

                if ($this->session) {
                    $decryption_password = openssl_decrypt($request->password, $this->ciphering, openssl_digest($request->user, 'MD5', TRUE), 0, $this->crypt_salt);

                    ssh2_auth_password($this->session, $server->user, $decryption_password);
                    $stream = ssh2_exec($this->session,  $script->command);
                    stream_set_blocking($stream, true);
                    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
                    $result = stream_get_contents($stream_out);

                    $server = Server::where('ip', $server->ip)->where('port', $server->port)->first();

                    $Data = [];
                    $Data['user_id'] = TokenControl::GetUserByRequest($request)->first()->id;
                    $Data['server_id'] = $server->id;
                    $Data['date'] = date("Y-m-d");
                    $Data['time'] = date("H:i:s");
                    $Data['command'] = $script->command;
                    $Data['result'] = $result;

                    Log::insert($Data);

                    return ['success' => true, 'content' => $result];
                }
            }

            return ['success' => false, 'content' => 'There is no connection to the server.'];
        }

        return ['success' => false, 'content' => 'Invalid send options specified.'];
    }

    public function __destruct() {
        ssh2_disconnect($this->session);
    }
}