<?php

namespace Softworx\RocXolid\Common;

use View;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Softworx\RocXolid\AbstractServiceProvider as RocXolidAbstractServiceProvider;

class ServiceProvider extends RocXolidAbstractServiceProvider
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
        $this->app->register(Providers\TranslationServiceProvider::class);
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
     * Expose config files and resources to be published.
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function publish(): RocXolidAbstractServiceProvider
    {
        // config files
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="config" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../config/general.php' => config_path('rocXolid/common/general.php'),
        ], 'config');

        // lang files
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="lang" (--force to overwrite)
        $this->publishes([
            //__DIR__ . '/../resources/lang' => resource_path('lang/vendor/softworx/rocXolid/common'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/rocXolid:common'),
        ], 'lang');

        // views files
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="views" (--force to overwrite)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/softworx/rocXolid/common'),
        ], 'views');

        // migrations
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="migrations" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');

        // db dumps
        // php artisan vendor:publish --provider="Softworx\RocXolid\Common\ServiceProvider" --tag="dumps" (--force to overwrite)
        $this->publishes([
            __DIR__.'/../database/dumps/' => database_path('dumps/rocXolid/common')
        ], 'dumps');

        return $this;
    }
}
