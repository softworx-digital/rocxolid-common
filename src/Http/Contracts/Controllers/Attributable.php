<?php

namespace Softworx\RocXolid\Common\Http\Contracts\Controllers;

// rocXolid utility
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid common model contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable as AttributableModel;
// rocXolid common models
use Softworx\RocXolid\Common\Models\AttributeGroup;

/**
 * Enables controller to handle dynamic model attributes assignment.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo: make this to boot consecutive routes
 */
interface Attributable
{
    /**
     * @todo: docblock
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup|null $attribute_group
     */
    public function modelAttributes(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null);

    /**
     * @todo: docblock
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup|null $attribute_group
     */
    public function modelAttributesStore(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null);
}
