<?php

namespace App\Http\Controllers;

use App\Servers;
use Illuminate\Http\Request;

class ServersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('servers\index', ['servers' => Servers::all()]);
    }
}
