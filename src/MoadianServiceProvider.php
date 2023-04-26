<?php

namespace Jooyeshgar\Moadian;

use Illuminate\Support\ServiceProvider;

class MoadianServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('moadian', function ($app) {
            return new Moadian(
                $app['config']['services.moadian.username'],
                $app['config']['services.moadian.private_key']
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/moadian.php' => config_path('services/moadian.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/moadian.php', 'services.moadian');
    }
}