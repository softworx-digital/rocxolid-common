<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// common models
use Softworx\RocXolid\Common\Models\City;

/**
 * Filter for BelongsTo City relation query.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid
 * @version 1.0.0
 */
class CityBelongsTo
{
    public function apply(Builder $query, Model $queried_model, City $city = null): Builder
    {
        if (is_null($city)) {
            return $query;
        }

        $foreign_key = sprintf('%s_%s', Str::snake((new \ReflectionClass($queried_model))->getShortName()), $queried_model->getKeyName());

        return $query
            ->join($city->getTable(), sprintf('%s.id', $queried_model->getTable()), '=', sprintf('%s.%s', $city->getTable(), $foreign_key))
            ->where(sprintf('%s.id', $city->getTable()), $city->getKey());
    }
}
