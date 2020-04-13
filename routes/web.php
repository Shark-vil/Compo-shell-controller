<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check())
        return view('welcome');
        
    return view('auth/login');
});

Route::get('/dev-help', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/profile/edit', 'ProfileController@settings')->name('profile.edit');
Route::get('/profile/edit/token', 'ProfileController@settingsToken')->name('profile.edit.token');

Route::get('/server', 'ServerController@index')->name('server');
Route::get('/server/add', 'ServerController@add')->name('server.add');
Route::get('/server/delete/{id}', 'ServerController@delete')->name('server.delete');
Route::get('/server/edit/{id}', 'ServerController@edit')->name('server.edit');
Route::get('/server/console/{id}', 'ServerController@console')->name('server.console');

Route::get('/server/logs/{id}', 'LogController@logs')->name('server.logs');
Route::get('/server/logs/{id}/{date}', 'LogController@logsDate')->name('server.logs.date');

Route::get('/server/scripts/{server_id}', 'ScriptController@index')->name('server.scripts');
Route::get('/server/scripts/{server_id}/add', 'ScriptController@add')->name('server.scripts.add');
Route::get('/server/scripts/{server_id}/{script_id}', 'ScriptController@edit')->name('server.scripts.edit');

// Route::middleware('auth.check')->get('/terminal', 'Api\ShellApiController@get_terminal');
