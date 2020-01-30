<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Country;

trait HasCountry
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
