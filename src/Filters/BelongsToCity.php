<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// rocXolid common models
use Softworx\RocXolid\Common\Models\City;

/**
 *
 */
class BelongsToCity
{
    public function apply(Builder $query, Model $queried_model, City $city = null)
    {
        if (is_null($city)) {
            return $query;
        }

        return $query->where(sprintf('%s.city_id', $queried_model->getTable()), $city->exists ? $city->getKey() : null);
    }
}
