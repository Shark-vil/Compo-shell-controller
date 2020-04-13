<?php

/**
 * API Server
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
 * API Server scripts
 */
Route::middleware('api.token')->get('/server/script', 'Api\ScriptApiController@get', function (Request $request) {
    return $request;
})->name('api.server.script');

Route::middleware('api.token')->post('/server/script', 'Api\ScriptApiController@post', function (Request $request) {
    return $request;
})->name('api.server.script');

Route::middleware('api.token')->put('/server/script', 'Api\ScriptApiController@put', function (Request $request) {
    return $request;
})->name('api.server.script');

Route::middleware('api.token')->delete('/server/script', 'Api\ScriptApiController@delete', function (Request $request) {
    return $request;
})->name('api.server.script');

/**
 * API Shell
 */
Route::middleware('api.token')->post('/shell/exec', 'Api\ShellApiController@post_exec', function (Request $request) {
    return $request;
})->name('api.shell.exec');

Route::middleware('api.token')->post('/shell/script-exec', 'Api\ShellApiController@post_script_exec', function (Request $request) {
    return $request;
})->name('api.shell.script-exec');

/**
 * API Profile
 */
Route::middleware('api.token')->put('/profile', 'Api\ProfileApiController@put', function (Request $request) {
    return $request;
})->name('api.profile');

/**
 * API Public token
 */
Route::middleware('api.token')->post('/public-token', 'Api\PublicApiController@post', function (Request $request) {
    return $request;
})->name('api.public-token');

Route::middleware('api.token')->delete('/public-token', 'Api\PublicApiController@delete', function (Request $request) {
    return $request;
})->name('api.public-token');