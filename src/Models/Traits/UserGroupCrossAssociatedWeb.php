<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Scopes\UserGroupCrossAssociatingWeb;

trait UserGroupCrossAssociatedWeb
{
    public static function bootUserGroupCrossAssociatedWeb()
    {
        static::addGlobalScope(new UserGroupCrossAssociatingWeb());
    }
}