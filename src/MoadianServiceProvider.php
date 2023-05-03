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

        $this->app->bind('Jooyeshgar\Moadian\Moadian', function ($app) {

            $config = $app['config']['moadian'];

            $privateKeyPath = $config['private_key_path'] ?? storage_path('app/keys/private.pem');
            $privateKey = file_get_contents($privateKeyPath);

            return new Moadian(
                $config['username'],
                $privateKey
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
            __DIR__.'/config/moadian.php' => config_path('moadian.php'),
        ], 'config');
    }
}
