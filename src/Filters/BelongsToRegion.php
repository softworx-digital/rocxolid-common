<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Region;

/**
 *
 */
class BelongsToRegion
{
    // @todo type hints, Illuminate\Database\Eloquent\Builder makes problems when used within Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete field
    public function apply($query, Model $queried_model, Region $region = null)
    {
        $foreign_key = sprintf('%s_%s', Str::snake((new \ReflectionClass($region))->getShortName()), $queried_model->getKeyName());

        return $query->where(sprintf('%s.%s', $queried_model->getTable(), $foreign_key), $region->exists ? $region->getKey() : null);
    }
}
