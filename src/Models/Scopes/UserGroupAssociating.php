<?php

namespace Softworx\RocXolid\Common\Models\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserGroupAssociating implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($user = Auth::guard('rocXolid')->user())
        {
            $user->applyGroupFilters($builder, $model->getQualifiedKeyName());
        }
    }
}