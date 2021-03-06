<?php

namespace Softworx\RocXolid\Common\Http\Controllers\WebFrontpageSettings;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid models
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid controller traits
use Softworx\RocXolid\Http\Controllers\Traits;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\WebFrontpageSettingsViewer;

/**
 * WebFrontpageSettings model CRUD controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = WebFrontpageSettingsViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
    ];

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): array
    {
        $model_viewer_component = $model->getModelViewerComponent();
        $web_model_viewer_component = $model->web->getModelViewerComponent();

        // event(new \App\Events\Estate\Changed($model->estate));

        return $this->response
            ->notifySuccess($web_model_viewer_component->translate('text.updated'))
            ->replace($web_model_viewer_component->getDomId('frontpage-settings'), $web_model_viewer_component->fetch('include.frontpage-settings'))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function successNonAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): Response
    {
        return redirect($model->estate->getControllerRoute('show', [ 'tab' => 'gaugers' ]));
    }
}
