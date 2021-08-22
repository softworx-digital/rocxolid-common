<?php

namespace Softworx\RocXolid\Common\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid common package provider
use Softworx\RocXolid\Common\ServiceProvider as PackageServiceProvider;

/**
 * rocXolid translation service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class TranslationServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid translation services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load();

        return $this;
    }

    /**
     * Load translations.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load()
    {
        $this->loadTranslationsFrom(PackageServiceProvider::translationsSourcePath(dirname(dirname(__DIR__))), 'rocXolid-common');

        return $this;
    }
}
