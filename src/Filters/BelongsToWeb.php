<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// common models
use Softworx\RocXolid\Common\Models\Web;

/**
 *
 */
class BelongsToWeb
{
    public function apply(Builder $query, Model $queried_model, Web $web)
    {
        return $query->where(sprintf('%s.web_id', $queried_model->getTable()), $web->exists ? $web->id : null);
    }
}
