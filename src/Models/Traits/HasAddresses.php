<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Address;

/**
 * Trait to add addresses relation to the model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Admin
 * @version 1.0.0
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
