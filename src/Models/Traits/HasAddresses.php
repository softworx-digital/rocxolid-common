<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Collection,
    Illuminate\Database\Eloquent\Relations\Relation;
// common models
use Softworx\RocXolid\Common\Models\Address;
/**
 *
 */
trait HasAddresses
{
    public function addresses(): Relation
    {
        return $this->morphMany(Address::class, 'model');
    }

    public function address(): Address
    {
        return $this->morphMany(Address::class, 'model')->where('is_default', 1)->get();
    }
}