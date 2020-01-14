<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Address;

use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Address;
use Softworx\RocXolid\Common\Repositories\Address\Repository;
use Softworx\RocXolid\Common\Components\ModelViewers\AddressViewer;
// events
use Softworx\RocXolid\Common\Events\Address\Changed as AddressChanged;

class Controller extends AbstractCrudController
{
    protected static $model_class = Address::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return AddressViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $model, string $action)
    {
        if ($request->ajax()) {
            $model_viewer_component = $model->getModelViewerComponent();

            event(new AddressChanged($model, $this->response));

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->replace($model_viewer_component->getDomId(), $model_viewer_component->fetch())
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        } else {
            return parent::successResponse($request, $repository, $form, $model, $action);
        }
    }

    // @todo: type hints
    // @todo: hotfixed
    protected function allowPermissionException($user, $action, $permission, CrudableModel $model = null)
    {
        $data = collect(request()->get('_data'));

        if ($data->has('model_type') && $data->has('model_id')) {
            switch ($data->get('model_type')) {
                case 'user':
                    return $data->get('model_id') == $user->id;
            }
        }

        $data = collect(request()->route()->parameters());

        if ($data->has('address')) {
            return $this->getRepository()->findOrFail($data->get('address'))->parent->is($user);
        }

        if ($data->has('id')) {
            return $this->getRepository()->findOrFail($data->get('id'))->parent->is($user);
        }

        return false;
    }
}
