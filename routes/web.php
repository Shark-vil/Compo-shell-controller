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

Route::get('/server', 'ServerController@index')->name('server');
Route::get('/server/add', 'ServerController@add')->name('server.add');
Route::get('/server/console/{id}', 'ServerController@console')->name('server.console');
Route::get('/server/scripts/{id}', 'ServerController@scripts')->name('server.scripts');
Route::get('/server/delete/{id}', 'ServerController@delete')->name('server.delete');
Route::get('/server/edit/{id}', 'ServerController@edit')->name('server.edit');
Route::get('/server/logs/{id}', 'ServerController@logs')->name('server.logs');
Route::get('/server/logs/{id}/{date}', 'ServerController@logsDate')->name('server.logs.date');

// Route::middleware('auth.check')->get('/terminal', 'Api\ShellApiController@get_terminal');
