<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    public function script()
    {
        return $this->hasMany('App\Script');
    }

    public function log()
    {
        return $this->hasMany('App\Log');
    }
}
