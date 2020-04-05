<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Address;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Address;
use Softworx\RocXolid\Common\Components\ModelViewers\AddressViewer;
// events
use Softworx\RocXolid\Common\Events\Address\Changed as AddressChanged;

class Controller extends AbstractCrudController
{
    protected static $model_viewer_type = AddressViewer::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
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
        // $this->authorize('sendTestNotification', $model);

        $this->setModel($model);

        $model_viewer_component = $this->getModelViewerComponent($this->getModel());

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

    protected function successResponse(CrudRequest $request, CrudableModel $model, AbstractCrudForm $form, string $action)
    {
        if ($request->ajax()) {
            $model_viewer_component = $model->getModelViewerComponent();

            event(new AddressChanged($model, $this->response));

            // @todo: "hotfixed", extremely ugly
            if ($request->has('_section') && ($request->input('_section') === 'location')) {
                $model_viewer_component->setViewPackage('app');
            }

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->replace($model_viewer_component->getDomId(), $model_viewer_component->fetch('related.show', [
                    'attribute' => 'address',
                    'relation' => 'parent'
                ])) // @todo: hardcoded, ugly
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        } else {
            return parent::successResponse($request, $model, $form, $action);
        }
    }
}
