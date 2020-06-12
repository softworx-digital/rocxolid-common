<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeValue;

use Illuminate\Http\Response;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid form contracts
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeGroupViewer;
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeViewer;
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeValueViewer;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common models
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * @todo: docblock
 */
class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = AttributeValueViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create.attribute-values' => 'create-in-attribute',
        'store.attribute-values' => 'create-in-attribute',
        'edit.attribute-values' => 'update-in-attribute',
        'update.attribute-values' => 'update-in-attribute',
    ];

    /**
     * Obtain attribute viewer.
     *
     * @param \Softworx\RocXolid\Common\Models\Attribute $attribute
     * @return \Softworx\RocXolid\Common\Components\ModelViewers\AttributeViewer
     */
    public function getAttributeViewerComponent(Attribute $attribute): AttributeViewer
    {
        return AttributeViewer::build($this, $this)
            ->setModel($attribute)
            ->setController($this);
    }

    /**
     * Obtain attribute group viewer.
     *
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group
     * @return \Softworx\RocXolid\Common\Components\ModelViewers\AttributeGroupViewer
     */
    public function getAttributeGroupViewerComponent(AttributeGroup $attribute_group): AttributeGroupViewer
    {
        return AttributeGroupViewer::build($this, $this)
            ->setModel($attribute_group)
            ->setController($this);
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $attribute_value, AbstractCrudForm $form): array
    {
        $model_viewer_component = $this->getModelViewerComponent($attribute_value);

        $attribute_group_model_viewer_component = $this->getAttributeGroupViewerComponent($attribute_value->attribute->attributeGroup);
        $attribute_model_viewer_component = $this->getAttributeViewerComponent($attribute_value->attribute);
        $template_name = sprintf('include.%s', $request->_section);

        dd(__METHOD__, '@todo');
        /*
        switch ($action) {
            case 'create':
                $this->response->replace($attribute_group_model_viewer_component->getDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes'));
                break;
        }
        */

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($attribute_model_viewer_component->getDomId($request->_section), $attribute_model_viewer_component->fetch($template_name))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyAjaxResponse(CrudRequest $request, CrudableModel $attribute_value): array
    {
        $model_viewer_component = $this->getModelViewerComponent($attribute_value);

        $attribute_group_model_viewer_component = $this->getAttributeGroupViewerComponent($attribute_value->attribute->attributeGroup);
        $attribute_model_viewer_component = $this->getAttributeViewerComponent($attribute_value->attribute);

        return $this->response
            ->replace($attribute_group_model_viewer_component->getDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes'))
            ->replace($attribute_model_viewer_component->getDomId('attribute-values'), $attribute_model_viewer_component->fetch('include.attribute-values'))
            ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm', $attribute_value->getKey()))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyNonAjaxResponse(CrudRequest $request, CrudableModel $attribute)//: Response
    {
        return redirect($attribute_value->attribute->getControllerRoute());
    }
}
