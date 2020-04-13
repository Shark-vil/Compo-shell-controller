<?php

/**
 * API Servers
 */
Route::middleware('api.token')->get('/server', 'Api\ServerApiController@get', function (Request $request) {
    return $request;
})->name('api.server');

Route::middleware('api.token')->post('/server', 'Api\ServerApiController@post', function (Request $request) {
    return $request;
})->name('api.server');

Route::middleware('api.token')->put('/server', 'Api\ServerApiController@put', function (Request $request) {
    return $request;
})->name('api.server');

Route::middleware('api.token')->delete('/server', 'Api\ServerApiController@delete', function (Request $request) {
    return $request;
})->name('api.server');

/**
 * API Shell
 */
Route::middleware('api.token')->post('/shell/exec', 'Api\ShellApiController@post_exec', function (Request $request) {
    return $request;
})->name('api.shell.exec');