<?php

namespace Softworx\RocXolid\Common\Models\Scopes;

use Auth;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class UserGroupCrossAssociatingWeb implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if ($user = Auth::guard('rocXolid')->user())
        {
            $relation = $model->webs();
            $builder->whereHas('webs', function ($query) use ($user, $relation) {
                $user->applyGroupFilters($query, $relation->getRelated()->getQualifiedKeyName());
            })->orDoesntHave('webs');
            /*
            $relation = $model->webs();
            $builder
                ->join($relation->getRelated()->getTable(), $relation->getQualifiedForeignKeyName(), '=', $model->getQualifiedKeyName())
                ->select(sprintf('%s.*', $model->getTable()));

            $user->applyGroupFilters($builder, $relation->getRelated()->getQualifiedKeyName());
            */
        }
    }
}