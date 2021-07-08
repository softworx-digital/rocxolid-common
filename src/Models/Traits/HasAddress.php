<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid common models
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
        return $this->morphOne(Address::class, 'model')->where(Address::make()->qualifyColumn('model_attribute'), 'address');
    }
}
