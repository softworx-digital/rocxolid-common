<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Error;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\Error as ErrorModelViewer;

/**
 * @todo
 */
class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = ErrorModelViewer::class;
}
