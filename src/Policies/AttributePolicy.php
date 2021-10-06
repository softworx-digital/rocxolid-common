<?php

namespace Softworx\RocXolid\Common\Policies;

// rocXolid user management contracts
use Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization;
// rocXolid user management policies
use Softworx\RocXolid\UserManagement\Policies\CrudPolicy;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * Attribute specific policy rules.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class AttributePolicy extends CrudPolicy
{
    /**
     * {@inheritDoc}
     */
    public function checkAllowRootAccess(HasAuthorization $user, string $ability): ?bool
    {
        if (collect([ 'setValues' ])->contains($ability)) {
            return null;
        }

        return parent::checkAllowRootAccess($user, $ability);
    }

    /**
     * Determine whether a Attribute can have pre-set values.
     *
     * @param \Softworx\RocXolid\UserManagement\Models\Contracts\HasAuthorization $user
     * @param \Softworx\RocXolid\Common\Models\Attribute $model
     * @param string|null $attribute
     * @param string|null $forced_scope_type
     * @return bool
     */
    public function setValues(HasAuthorization $user, Attribute $model, ?string $attribute = null, ?string $forced_scope_type = null): bool
    {
        return $model->isType('enum');
    }
}
