<?php

namespace Softworx\RocXolid\Common;

use Illuminate\Foundation\AliasLoader;
// rocXolid service providers
use Softworx\RocXolid\AbstractServiceProvider as RocXolidAbstractServiceProvider;

/**
 * rocXolid Common package primary service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class ServiceProvider extends RocXolidAbstractServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(Providers\AuthServiceProvider::class);
        $this->app->register(Providers\ConfigurationServiceProvider::class);
        $this->app->register(Providers\ViewServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\TranslationServiceProvider::class);
        $this->app->register(Providers\FactoryServiceProvider::class);

        $this
            ->bindContracts()
            ->bindAliases(AliasLoader::getInstance());
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
     * Bind contracts / facades, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $this->app->bind(<SomeContract>::class, <SomeImplementation>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindContracts(): RocXolidAbstractServiceProvider
    {
        $this->app->singleton(
            Services\Contracts\FileUploadService::class,
            Services\FileUploadService::class
        );

        $this->app->singleton(
            Services\Contracts\ImageProcessService::class,
            Services\ImageProcessService::class
        );

        $this->app->bind(
            \Softworx\RocXolid\Common\Models\Contracts\Attributable::class,
            \Softworx\RocXolid\Common\Models\AttributableDummy::class
        );

        // @todo doesn't work since this is appliable to constructor dependency resolution
        // need to refactor forms in general at first
        /*
        $this->app->when(Models\Forms\AttributeModel\General::class)
            ->needs(\Softworx\RocXolid\Forms\Builders\Contracts\FormFieldFactory::class)
            ->give(function () {
                return app(Models\Forms\Attribute\Support\FormFieldFactory);
            });
        */

        return $this;
    }

    /**
     * Bind aliases, so they don't have to be added to config/app.php.
     *
     * Usage:
     *      $loader->alias('<alias>', <Facade/>Contract>::class);
     *
     * @return \Softworx\RocXolid\AbstractServiceProvider
     */
    private function bindAliases(AliasLoader $loader): RocXolidAbstractServiceProvider
    {
        return $this;
    }
}
