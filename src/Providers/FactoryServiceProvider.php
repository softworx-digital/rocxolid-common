<?php

namespace Softworx\RocXolid\Common\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * rocXolid factory service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class FactoryServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot factories.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this->loadFactoriesFrom(realpath(__DIR__ . '/../../database/factories'));

        return $this;
    }
}
