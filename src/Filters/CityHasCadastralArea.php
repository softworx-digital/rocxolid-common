<?php

namespace Softworx\RocXolid\Common\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// rocXolid common models
use Softworx\RocXolid\Common\Models\City;
use Softworx\RocXolid\Common\Models\CadastralArea;

/**
 *
 */
class CityHasCadastralArea
{
    public function apply($query, City $city)
    {
        return $query
            ->join($city->cadastralAreas()->make()->getTable(), $city->cadastralAreas()->getQualifiedParentKeyName(), '=', $city->cadastralAreas()->getQualifiedForeignKeyName());
    }
}
