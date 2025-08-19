<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Auth\MultiTableUserProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['auth']->provider('multi-table', function ($app, array $config) {
            return new MultiTableUserProvider($app['hash'], $config['model']);
        });
    }
}