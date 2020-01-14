<?php

namespace Softworx\RocXolid\Common\Http\Traits\Controllers;

use App;
// rocXolid fundamentals
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
use Softworx\RocXolid\Repositories\Contracts\Repository;
// common components
use Softworx\RocXolid\Common\Components\Forms\Attribute\CrudForm as AttributeCrudFormComponent;
// common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable as AttributableModel;
// common controllers
use Softworx\RocXolid\Common\Http\Controllers\AttributeModel\Controller as AttributeModelController;

/**
 *
 */
trait Attributable
{
    public function modelAttributes(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->findOrFail($id));

        if (!$this->getModel() instanceof AttributableModel) {
            throw new \RuntimeException(sprintf('%s is not instance of %s', get_class($this->getModel()), AttributableModel::class));
        }

        $attribute_model_controller = App::make(AttributeModelController::class);
        $attribute_model_repository = $attribute_model_controller->getRepository($attribute_model_controller->getRepositoryParam($request));
        $attribute_model_controller->setModel($this->getModel());

        $form = $attribute_model_repository->getForm('model');
        $form->setCustomOptions([
            'route-action' => $this->getRoute('modelAttributesStore', $this->getModel()),
        ]);

        $form_component = (new AttributeCrudFormComponent())
            ->setForm($form)
            ->setRepository($repository);

        $model_viewer_component = $this
            ->getModelViewerComponent($this->getModel())
            ->setFormComponent($form_component);

        if ($request->ajax()) {
            return $this->response
                ->modal($model_viewer_component->fetch('modal.attributes'))
                ->get();
        } else {
            return $this
                ->getDashboard()
                ->setModelViewerComponent($model_viewer_component)
                ->render('model', [
                    'model_viewer_template' => 'update'
                ]);
        }
    }

    public function modelAttributesStore(CrudRequest $request, $id)
    {
        $repository = $this->getRepository($this->getRepositoryParam($request));

        $this->setModel($repository->findOrFail($id));

        if (!$this->getModel() instanceof AttributableModel) {
            throw new \RuntimeException(sprintf('%s is not instance of %s', get_class($this->getModel()), AttributableModel::class));
        }

        $attribute_model_controller = App::make(AttributeModelController::class);
        $attribute_model_repository = $attribute_model_controller->getRepository($attribute_model_controller->getRepositoryParam($request));
        $attribute_model_controller->setModel($this->getModel());

        $form = $attribute_model_repository->getForm('model');
        $form
            //->adjustCreate($request)
            ->adjustCreateBeforeSubmit($request)
            ->submit();

        if ($form->isValid()) {
            return $this->successAttributes($request, $repository, $form, 'attributes');
        } else {
            return $this->errorResponse($request, $repository, $form, 'attributes');
        }
    }

    protected function successAttributes(CrudRequest $request, Repository $repository, AbstractCrudForm $form, string $action)
    {
        $attribute_model_controller = App::make(AttributeModelController::class);
        $attribute_model_repository = $attribute_model_controller->getRepository($attribute_model_controller->getRepositoryParam($request));

        $model = $attribute_model_repository->updateModel($form->getFormFieldsValues()->toArray(), $this->getModel(), $action);

        return $this->successResponse($request, $repository, $form, $model, $action);
    }
}
