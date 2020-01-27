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
trait HasAddresses
{
    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }
}
