<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;

class LogController extends Controller
{
    public function logs(int $id) {
        $logs = Log::where('server_id', $id)->select('date')->groupBy('date')->get();

        if ($logs)
            return view('server\logs', ['id' => $id, 'logs' => $logs]);

        return redirect()->route('server');
    }

    public function logsDate(int $id, string $date)
    {
        $logs = Log::where('date', $date)->get();

        if ($logs)
            return view('server\logs-view', ['date' => $date, 'id' => $id, 'logs' => $logs]);

        return redirect()->route('server');
    }
}
