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

Route::get('/servers', 'ServersController@index')->name('servers');
Route::get('/servers/add', 'ServersController@add')->name('servers.add');
Route::get('/servers/console/{id}', 'ServersController@console')->name('servers.console');
Route::get('/servers/delete/{id}', 'ServersController@delete')->name('servers.delete');
Route::get('/servers/edit/{id}', 'ServersController@edit')->name('servers.edit');

Route::get('/logs', 'LogsController@index')->name('logs');

// Route::middleware('auth.check')->get('/terminal', 'Api\ShellApiController@get_terminal');
