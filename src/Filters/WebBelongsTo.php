<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;

/**
 *
 */
class WebBelongsTo
{
    public function apply(Builder $query, Model $queried_model, Web $web)
    {
        $foreign_key = sprintf('%s_%s', Str::snake((new \ReflectionClass($queried_model))->getShortName()), $queried_model->getKeyName());

        return $query
            ->join($web->getTable(), sprintf('%s.id', $queried_model->getTable()), '=', sprintf('%s.%s', $web->getTable(), $foreign_key))
            ->where(sprintf('%s.id', $web->getTable()), $web->getKey());
    }
}
