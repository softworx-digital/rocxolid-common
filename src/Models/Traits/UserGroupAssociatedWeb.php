<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Scopes\UserGroupAssociatingWeb;

/**
 *
 */
trait UserGroupAssociatedWeb
{
    public static function bootUserGroupAssociatedWeb()
    {
        static::addGlobalScope(new UserGroupAssociatingWeb());
    }
}
