<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Web;

// rocXolid controller traits
use Softworx\RocXolid\Http\Controllers\Traits;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\Web as WebModelViewer;

/**
 * Web model CRUD controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    use Traits\Utils\HasSectionResponse;

    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = WebModelViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        //
        'edit.panel.data.general' => 'update-general-data',
        'update.panel.data.general' => 'update-general-data',
        //
        'edit.panel:single.data.description' => 'update-description-data',
        'update.panel:single.data.description' => 'update-description-data',
        //
        'edit.panel.data.localization' => 'update-localization-data',
        'update.panel.data.localization' => 'update-localization-data',
        //
        'edit.panel.data.label' => 'update-label-data',
        'update.panel.data.label' => 'update-label-data',
        //
        'edit.panel.data.error-not-found' => 'update-error-not-found-data',
        'update.panel.data.error-not-found' => 'update-error-not-found-data',
        //
        'edit.panel.data.error-exception' => 'update-error-exception-data',
        'update.panel.data.error-exception' => 'update-error-exception-data',
    ];
}
