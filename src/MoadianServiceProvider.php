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
        $this->mergeConfigFrom(
            __DIR__.'/config/moadian.php', 'moadian'
        );

        $this->app->singleton('Jooyeshgar\Moadian\MoadianManager', function ($app) {
            return new MoadianManager($app);
        });

        $this->app->alias('Jooyeshgar\Moadian\MoadianManager', 'moadian');

        // Keep backward compatibility - bind Moadian to the default account
        $this->app->bind('Jooyeshgar\Moadian\Moadian', function ($app) {
            return $app->make('Jooyeshgar\Moadian\MoadianManager')->account();
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
            __DIR__.'/config/moadian.php' => config_path('moadian.php'),
        ], 'config');

        if (file_exists(__DIR__.'/helpers.php')) {
            require_once __DIR__.'/helpers.php';
        }
    }
}
