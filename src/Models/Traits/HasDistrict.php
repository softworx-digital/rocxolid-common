<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\District;

trait HasDistrict
{
    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
