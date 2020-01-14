<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Scopes\UserGroupAssociating;

trait UserGroupAssociated
{
    public static function bootUserGroupAssociated()
    {
        static::addGlobalScope(new UserGroupAssociating());
    }
}
