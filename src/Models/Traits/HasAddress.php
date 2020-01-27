<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
// common models
use Softworx\RocXolid\Common\Models\Address;

/**
 *
 */
trait HasAddress
{
    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('is_default', 1);
    }
}
