<?php

namespace Softworx\RocXolid\Common\Providers;

use View;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * rocXolid views & composers service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class ViewServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid view services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load()
            ->setComposers();

        return $this;
    }

    /**
     * Load views.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(): IlluminateServiceProvider
    {
        // customized views preference
        $this->loadViewsFrom(resource_path('views/vendor/rocXolid/common'), 'rocXolid:common');
        // pre-defined views fallback
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'rocXolid:common');

        return $this;
    }

    /**
     * Set view composers for blade templates.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    private function setComposers(): IlluminateServiceProvider
    {
        foreach (config('rocXolid.common.general.composers', []) as $view => $composer) {
            View::composer($view, $composer);
        }

        return $this;
    }
}
