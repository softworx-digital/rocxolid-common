<?php

namespace Softworx\RocXolid\Common\Models\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * @todo: documentation
 */
interface Attributable
{
    public function attributeValues(): Relations\MorphToMany;

    public function attributeGroups(): Collection;

    public function attributeValue(Attribute $attribute, $raw = false);
}
