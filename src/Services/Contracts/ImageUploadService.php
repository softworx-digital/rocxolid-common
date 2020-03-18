<?php

namespace Softworx\RocXolid\Common\Services\Contracts;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Resizable;

/**
 * Service to handle image uploads.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
interface ImageUploadService
{
    /**
     * Handle physical image resize assigned to model.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Resizable $model
     * @return \Softworx\RocXolid\Models\Contracts\Resizable
     */
    public function handleResize(Resizable $model): Resizable;
}
