<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeModel;

use App;
use Symfony\Component\HttpFoundation\Response;
// rocXolid fundamentals
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid components
use Softworx\RocXolid\Components\General\Message;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
use Softworx\RocXolid\Components\Forms\CrudForm as CrudFormComponent;
// common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Http\Controllers\Attribute\Controller as AttributeController;
// common repositories
use Softworx\RocXolid\Common\Repositories\AttributeModel\Repository;
// common models
use Softworx\RocXolid\Common\Models\AttributeModel;
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\Attribute;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 *
 */
class Controller extends AbstractCrudController
{
    protected static $model_class = AttributeModel::class;

    protected static $repository_class = Repository::class;

    protected $form_mapping = [

    ];

    /*
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

    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, CrudableModel $attribute_value, string $action)
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
                    $this->response->replace($attribute_group_model_viewer_component->getDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes', $assignments));
                    break;
            }

            return $this->response
                ->append($form_component->getDomId('output'), (new Message())->fetch('crud.success', $assignments))
                ->replace($attribute_model_viewer_component->getDomId($request->_section), $attribute_model_viewer_component->fetch($template_name, $assignments))
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
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
                ->replace($attribute_group_model_viewer_component->getDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes', $assignments))
                ->replace($attribute_model_viewer_component->getDomId('attribute-values'), $attribute_model_viewer_component->fetch('include.attribute-values', $assignments))
                ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm', $attribute_value->id))
                ->get();
        }
        else
        {
            $attribute_controller = App::make(AttributeController::class);

            return redirect($attribute_controller->getRoute('show', $attribute_value->attribute));
        }
    }
    */
}