<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Attribute;

use App;
// rocXolid fundamentals
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
// common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeViewer;
// common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Http\Controllers\AttributeGroup\Controller as AttributeGroupController;
// common repositories
use Softworx\RocXolid\Common\Repositories\Attribute\Repository;
// common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 *
 */
class Controller extends AbstractCrudController
{
    protected static $model_class = Attribute::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create.attributes' => 'create-in-attribute-group',
        'store.attributes' => 'create-in-attribute-group',
        'edit.attributes' => 'update-in-attribute-group',
        'update.attributes' => 'update-in-attribute-group',
    ];

    public function getAttributeViewerComponent(Attribute $attribute): CrudModelViewerComponent
    {
        return AttributeViewer::build($this, $this)
            ->setModel($attribute)
            ->setController($this);
    }

    public function setValues(CrudRequest $request, Attribute $attribute)
    {
        $model_viewer_component = $this->getAttributeViewerComponent($attribute);

        return $this->response
            ->modal($model_viewer_component->fetch('modal.attribute-values', [ 'attribute' => $attribute ]))
            ->get();
    }

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $attribute, string $action)
    {
        if ($request->ajax() && $request->has('_section')) {
            $assignments = [];

            $form_component = CrudFormComponent::build($this, $this)
                ->setForm($form)
                ->setRepository($this->getRepository());

            $model_viewer_component = $this->getModelViewerComponent($attribute);

            $attribute_group_controller = App::make(AttributeGroupController::class);
            $attribute_group_model_viewer_component = $attribute_group_controller->getModelViewerComponent($attribute->attributeGroup);
            $template_name = sprintf('include.%s', $request->_section);

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->replace($attribute_group_model_viewer_component->getDomId($request->_section), $attribute_group_model_viewer_component->fetch($template_name, $assignments))
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        } else {
            return parent::successResponse($request, $repository, $form, $attribute, $action);
        }
    }

    protected function destroyResponse(CrudRequest $request, CrudableModel $attribute)
    {
        if ($request->ajax()) {
            $assignments = [];

            $model_viewer_component = $this->getModelViewerComponent($attribute);

            $attribute_group_controller = App::make(AttributeGroupController::class);
            $attribute_group_model_viewer_component = $attribute_group_controller->getModelViewerComponent($attribute->attributeGroup);

            return $this->response
                ->replace($attribute_group_model_viewer_component->getDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes', $assignments))
                ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm'))
                ->get();
        } else {
            $attribute_group_controller = App::make(AttributeGroupController::class);

            return redirect($attribute_group_controller->getRoute('show', $attribute->attributeGroup));
        }
    }
}
