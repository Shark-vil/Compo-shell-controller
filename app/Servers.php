<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'user', 'password',
    ];
}
