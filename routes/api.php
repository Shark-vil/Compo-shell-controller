<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * API Servers
 */
Route::middleware('api.token')->get('/servers', 'Api\ServersApiController@get', function (Request $request) {
    return $request;
});

Route::middleware('api.token')->post('/servers', 'Api\ServersApiController@post', function (Request $request) {
    return $request;
});

Route::middleware('api.token')->put('/servers', 'Api\ServersApiController@put', function (Request $request) {
    return $request;
});

Route::middleware('api.token')->delete('/servers', 'Api\ServersApiController@delete', function (Request $request) {
    return $request;
});

/**
 * API Shell
 */
Route::middleware('api.token')->post('/shell', 'Api\ShellApiController@post_exec', function (Request $request) {
    return $request;
});