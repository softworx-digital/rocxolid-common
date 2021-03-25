<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Scopes\UserGroupAssociating;

trait UserGroupAssociated
{
    public static function bootUserGroupAssociated()
    {
        // @todo hotfixed, causes problems with Softworx\RocXolid\Common\Http\Traits\DetectsWeb
        // when users are not assigned to web's group
        // static::addGlobalScope(new UserGroupAssociating());
    }
}
