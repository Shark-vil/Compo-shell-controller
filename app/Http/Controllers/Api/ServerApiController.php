<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Server;
use App\Script;
use App\Log;

use Illuminate\Http\Request;

class ServerApiController extends Controller
{
    private $ciphering = "AES-128-CTR";
    private $crypt_salt = '1234567891011121';

    public function get(Request $request)
    {
        if (!$request->id) {
            return ['success' => true, 'content' => Server::all()];
        }
        return ['success' => true, 'content' => Server::where('id', $request->id)->first()];
    }

    public function post(Request $request)
    {
        if ($request->ip && $request->port && $request->user && $request->password) {

            if (Server::where('ip', $request->ip)->where('port', $request->port)->where('user', $request->user)->first()) {
                return ['success' => false, 'content' => 'This server is exists.'];
            }

            $new_password = openssl_encrypt($request->password, $this->ciphering, openssl_digest($request->user, 'MD5', TRUE), 0, $this->crypt_salt);
            $request->merge(['password' => $new_password]);

            $LastId = Server::insertGetId($request->except('token', '_token'));

            return ['success' => true, 'content' => Server::where('id', $LastId)->first()];
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function put(Request $request)
    {
        if ($request->id) {
            if ($request->ip || $request->port || ($request->user && $request->password)) {
                if ($request->user) {
                    $new_password = openssl_encrypt($request->password, $this->ciphering, openssl_digest($request->user, 'MD5', TRUE), 0, $this->crypt_salt);
                    $request->merge(['password' => $new_password]);
                }

                Server::where('id', $request->id)->update($request->except('token', '_token'));
                return ['success' => true, 'content' => Server::where('id', $request->id)->first()];
            }
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }

    public function delete(Request $request)
    {        
        if ($request->id) {
            $server = Server::where('id', $request->id);
            $TempData = $server->first();
            
            if (!$TempData) {
                return ['success' => false, 'content' => 'There is no such entry.']; 
            }

            foreach($TempData->script()->get() as $script) {
                $script->delete();
            }

            foreach($TempData->log()->get() as $log) {
                $log->delete();
            }

            $server->delete();
            return ['success' => true, 'content' => $TempData]; 
        }

        return ['success' => false, 'content' => 'Bad arguments.'];
    }
}