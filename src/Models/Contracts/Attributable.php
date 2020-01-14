<?php

namespace Softworx\RocXolid\Common\Models\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
// common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 *
 */
interface Attributable
{
    public function attributeValues(): Relation;

    public function attributeGroups(): Collection;

    public function attributeValue(Attribute $attribute, $raw = false);
}
