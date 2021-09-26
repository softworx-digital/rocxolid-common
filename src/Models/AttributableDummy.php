<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable;
// rocXolid common traits
use Softworx\RocXolid\Common\Models\Traits as CommonTraits;
// rocXolid commerce models
use Softworx\RocXolid\Commerce\Models\Product;
// rocXolid commerce traits
use Softworx\RocXolid\Commerce\Models\Traits;

/**
 * @todo
 * The sole purpose of this class is to be used for instantiating Attributable contract not to break down other fcionality such as permission assignment.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class AttributableDummy extends AbstractCrudModel implements Attributable
{
    use CommonTraits\HasDynamicAttributes;
}
