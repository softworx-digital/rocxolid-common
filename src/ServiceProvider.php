<?php

namespace Softworx\RocXolid\Common;

use View;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Softworx\RocXolid\CrudRouter;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Providers\ConfigurationServiceProvider::class);
        $this->app->register(Providers\ViewServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
    }

     /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this
            ->publish();
    }

    /**
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function publish()
    {
        // views files
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/softworx/rocxolid-common'),
        ], 'views');

        // migrations
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="migrations" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        return $this;
    }
}
