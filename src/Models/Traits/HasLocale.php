<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Locale;

trait HasLocale
{
    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}