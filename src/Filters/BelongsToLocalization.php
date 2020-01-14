<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// common models
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
 */
class BelongsToLocalization
{
    public function apply(Builder $query, Model $queried_model, Localization $localization)
    {
        return $query->where(sprintf('%s.localization_id', $queried_model->getTable()), $localization->exists ? $localization->id : null);
    }
}
