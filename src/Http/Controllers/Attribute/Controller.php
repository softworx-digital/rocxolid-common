<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Attribute;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid form contracts
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeViewer;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * @todo: docblock
 */
class Controller extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = AttributeViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create.attributes' => 'create-in-attribute-group',
        'store.attributes' => 'create-in-attribute-group',
        'edit.attributes' => 'update-in-attribute-group',
        'update.attributes' => 'update-in-attribute-group',
    ];

    /**
     * @todo: docblock
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Attribute $attribute
     */
    public function setValues(CrudRequest $request, Attribute $attribute)
    {
        $model_viewer_component = $this->getAttributeViewerComponent($attribute);

        return $this->response
            ->modal($model_viewer_component->fetch('modal.attribute-values', [ 'attribute' => $attribute ]))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $attribute, AbstractCrudForm $form)
    {
        $model_viewer_component = $this->getModelViewerComponent($attribute);
        $attribute_group_model_viewer_component = $attribute->attributeGroup->getModelViewerComponent();
        $template_name = sprintf('include.%s', $request->_section);

        return $this->response
            ->notifySuccess($model_viewer_component->translate('text.updated'))
            ->replace($attribute_group_model_viewer_component->getDomId($request->_section), $attribute_group_model_viewer_component->fetch($template_name))
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyAjaxResponse(CrudRequest $request, CrudableModel $attribute)
    {
        $model_viewer_component = $this->getModelViewerComponent($attribute);
        $attribute_group_model_viewer_component = $attribute->attributeGroup->getModelViewerComponent();

        return $this->response
            ->replace($attribute_group_model_viewer_component->getDomId('attributes'), $attribute_group_model_viewer_component->fetch('include.attributes'))
            ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm'))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyNonAjaxResponse(CrudRequest $request, CrudableModel $attribute)
    {
        return redirect($attribute->attributeGroup->getControllerRoute());
    }
}
