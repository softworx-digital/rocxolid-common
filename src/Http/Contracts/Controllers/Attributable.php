<?php

namespace Softworx\RocXolid\Common\Http\Contracts\Controllers;

use Softworx\RocXolid\Http\Requests\CrudRequest;
/**
 *
 */
interface Attributable
{
    public function modelAttributes(CrudRequest $request, $id);

    public function modelAttributesStore(CrudRequest $request, $id);
}