<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// common models
use Softworx\RocXolid\Common\Models\Country;

/**
 *
 */
class BelongsToCountry
{
    // @todo type hints, Illuminate\Database\Eloquent\Builder makes problems when used within Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete field
    public function apply($query, Model $queried_model, Country $country = null)
    {
        $foreign_key = sprintf('%s_%s', Str::snake((new \ReflectionClass($country))->getShortName()), $queried_model->getKeyName());

        return $query->where(sprintf('%s.%s', $queried_model->getTable(), $foreign_key), $country->exists ? $country->getKey() : null);
    }
}
