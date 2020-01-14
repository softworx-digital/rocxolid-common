<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Language;

trait HasLanguage
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
