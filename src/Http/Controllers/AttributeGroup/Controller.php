<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeGroup;

// rocXolid controller traits
use Softworx\RocXolid\Http\Controllers\Traits;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeGroupViewer;

/**
 * AttributeGroup controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    // use DetachesFromContainer;
    use Traits\Utils\HasSectionResponse;

    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = AttributeGroupViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        //
    ];

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit.general-data' => 'update-general',
        'update.general-data' => 'update-general',
        'edit.description-data' => 'update-description',
        'update.description-data' => 'update-description',
        'edit.note-data' => 'update-note',
        'update.note-data' => 'update-note',
    ];
}
