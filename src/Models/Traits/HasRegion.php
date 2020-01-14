<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Region;

trait HasRegion
{
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
