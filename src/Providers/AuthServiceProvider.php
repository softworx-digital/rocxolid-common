<?php

namespace Softworx\RocXolid\Common\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateAuthServiceProvider;
// rocXolid common policies
use Softworx\RocXolid\Common\Policies;
// rocXolid common models
use Softworx\RocXolid\Common\Models;

/**
 * rocXolid common authorization service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class AuthServiceProvider extends IlluminateAuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Attribute::class => Policies\AttributePolicy::class,
    ];

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->registerPolicies();
    }
}
