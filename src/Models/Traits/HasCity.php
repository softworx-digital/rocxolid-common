<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\City;

trait HasCity
{
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
