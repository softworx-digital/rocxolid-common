<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Nationality;

trait HasNationality
{
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
}
