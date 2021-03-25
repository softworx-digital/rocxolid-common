<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Web;

// rocXolid controller traits
use Softworx\RocXolid\Http\Controllers\Traits;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\WebViewer;

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
    protected static $model_viewer_type = WebViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit.general-data' => 'update-general',
        'update.general-data' => 'update-general',
        'edit.localization-data' => 'update-localization',
        'update.localization-data' => 'update-localization',
        'edit.description-data' => 'update-description',
        'update.description-data' => 'update-description',
        'edit.error-not-found-data' => 'update-error-not-found',
        'update.error-not-found-data' => 'update-error-not-found',
        'edit.error-exception-data' => 'update-error-exception',
        'update.error-exception-data' => 'update-error-exception',
        'edit.label-data' => 'update-label',
        'update.label-data' => 'update-label',
    ];
}
