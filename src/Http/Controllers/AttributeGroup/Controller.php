<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeGroup;

// rocXolid fundamentals
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeGroupViewer;
// common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// common models
use Softworx\RocXolid\Common\Models\AttributeGroup;

/**
 *
 */
class Controller extends AbstractCrudController
{
    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return AttributeGroupViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }
}
