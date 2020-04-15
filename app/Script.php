<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
    public function server()
    {
        return $this->belongsTo('App\Server');
    }
}
