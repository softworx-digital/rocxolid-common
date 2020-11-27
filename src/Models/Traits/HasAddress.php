<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
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
        $table = (new Address())->getTable();

        return $this->morphOne(Address::class, 'model')->where(sprintf('%s.model_attribute', $table), 'address');
    }
}
