<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeValue;

use App;
use Symfony\Component\HttpFoundation\Response;
// rocXolid fundamentals
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract,
    Softworx\RocXolid\Http\Requests\CrudRequest,
    Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel,
    Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid components
use Softworx\RocXolid\Components\General\Message;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
// common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeGroupViewer,
    Softworx\RocXolid\Common\Components\ModelViewers\AttributeViewer,
    Softworx\RocXolid\Common\Components\ModelViewers\AttributeValueViewer;
// common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController,
    Softworx\RocXolid\Common\Http\Controllers\Attribute\Controller as AttributeController;
// common repositories
use Softworx\RocXolid\Common\Repositories\AttributeValue\Repository;
// common models
use Softworx\RocXolid\Common\Models\AttributeGroup,
    Softworx\RocXolid\Common\Models\Attribute,
    Softworx\RocXolid\Common\Models\AttributeValue;
/**
 *
 */
class Controller extends AbstractCrudController
{
    protected static $model_class = AttributeValue::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [
        'create.attribute-values' => 'create-in-attribute',
        'store.attribute-values' => 'create-in-attribute',
        'edit.attribute-values' => 'update-in-attribute',
        'update.attribute-values' => 'update-in-attribute',
    ];

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return (new AttributeValueViewer())
            ->setModel($model)
            ->setController($this);
    }

    public function getAttributeViewerComponent(Attribute $attribute): CrudModelViewerComponent
    {
        return (new AttributeViewer())
            ->setModel($attribute)
            ->setController($this);
    }

    public function getAttributeGroupViewerComponent(AttributeGroup $attribute_group): CrudModelViewerComponent
    {
        return (new AttributeGroupViewer())
            ->setModel($attribute_group)
            ->setController($this);
    }

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $attribute_value, $action)
    {
        if ($request->ajax() && $request->has('_section'))
        {
            $assignments = [];

            $form_component = (new CrudFormComponent())
                ->setForm($form)
                ->setRepository($this->getRepository());

            $model_viewer_component = $this->getModelViewerComponent($attribute_value);

            $attribute_group_model_viewer_component = $this->getAttributeGroupViewerComponent($attribute_value->attribute->attributeGroup);
            $attribute_model_viewer_component = $this->getAttributeViewerComponent($attribute_value->attribute);
            $template_name = sprintf('include.%s', $request->_section);

            switch ($action)
            {
                case 'create':
                    $this->response->replace($attribute_group_model_viewer_component->makeDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes', $assignments));
                    break;
            }

            return $this->response
                ->append($form_component->getDomId('output'), (new Message())->fetch('crud.success', $assignments))
                ->replace($attribute_model_viewer_component->makeDomId($request->_section), $attribute_model_viewer_component->fetch($template_name, $assignments))
                ->modalClose($model_viewer_component->makeDomId(sprintf('modal-%s', $action)))
                ->get();
        }
        else
        {
            return parent::successResponse($request, $repository, $form, $attribute_value, $action);
        }
    }

    protected function destroyResponse(CrudRequest $request, CrudableModel $attribute_value)
    {
        if ($request->ajax())
        {
            $assignments = [];

            $model_viewer_component = $this->getModelViewerComponent($attribute_value);

            $attribute_group_model_viewer_component = $this->getAttributeGroupViewerComponent($attribute_value->attribute->attributeGroup);
            $attribute_controller = App::make(AttributeController::class);
            $attribute_model_viewer_component = $this->getAttributeViewerComponent($attribute_value->attribute);

            return $this->response
                ->replace($attribute_group_model_viewer_component->makeDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes', $assignments))
                ->replace($attribute_model_viewer_component->makeDomId('attribute-values'), $attribute_model_viewer_component->fetch('include.attribute-values', $assignments))
                ->modalClose($model_viewer_component->makeDomId('modal-destroy-confirm', $attribute_value->id))
                ->get();
        }
        else
        {
            $attribute_controller = App::make(AttributeController::class);

            return redirect($attribute_controller->getRoute('show', $attribute_value->attribute));
        }
    }
}