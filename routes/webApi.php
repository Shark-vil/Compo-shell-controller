<?php

/**
 * API Servers
 */
Route::middleware('api.token')->get('/servers', 'Api\ServersApiController@get', function (Request $request) {
    return $request;
})->name('api.servers');

Route::middleware('api.token')->post('/servers', 'Api\ServersApiController@post', function (Request $request) {
    return $request;
})->name('api.servers');

Route::middleware('api.token')->put('/servers', 'Api\ServersApiController@put', function (Request $request) {
    return $request;
})->name('api.servers');

Route::middleware('api.token')->delete('/servers', 'Api\ServersApiController@delete', function (Request $request) {
    return $request;
})->name('api.servers');

/**
 * API Shell
 */
Route::middleware('api.token')->post('/shell/exec', 'Api\ShellApiController@post_exec', function (Request $request) {
    return $request;
})->name('api.shell.exec');