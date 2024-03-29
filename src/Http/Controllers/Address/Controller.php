<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Address;

// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\Address as AddressModelViewer;
// rocXolid common events
use Softworx\RocXolid\Common\Events\Address\Changed as AddressChanged;

/**
 * Address model CRUD controller.
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
    protected static $model_viewer_type = AddressModelViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'create.location' => 'create-location',
        'store.location' => 'create-location',
        'edit' => 'update',
        'update' => 'update',
        'edit.location' => 'update-location',
        'update.location' => 'update-location',
    ];

    /**
     * Display the dialog with map location.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request Incoming request.
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     */
    public function showMap(CrudRequest $request, CrudableModel $model)//: View
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        if ($request->ajax()) {
            return $this->response
                ->modal($model_viewer_component->fetch('modal.map'))
                ->get();
        } else {
            return $this
                ->getDashboard()
                ->setModelViewerComponent($model_viewer_component)
                ->render('model', [
                    'model_viewer_template' => 'map'
                ]);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form): array
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        event(new AddressChanged($model, $this->response)); // @todo this doesn't belong here

        // @todo "hotfixed", extremely ugly
        if ($request->has('_section') && ($request->input('_section') === 'location')) {
            $model_viewer_component->setViewPackage('app');
        }

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($model_viewer_component->getDomId($model->getKey(), 'parent', $model->model_attribute), $model_viewer_component->fetch('related.show', [
                'attribute' => $model->model_attribute,
                'relation' => 'parent'
            ])) // @todo hardcoded, ugly
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }
}
