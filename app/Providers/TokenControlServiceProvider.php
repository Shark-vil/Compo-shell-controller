<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TokenControlServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('TokenControl', 'App\Services\TokenControl');
    }
}