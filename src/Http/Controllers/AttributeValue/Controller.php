<?php

namespace Softworx\RocXolid\Common\Http\Controllers\AttributeValue;

// rocXolid utils
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid form contracts
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common repositories
use Softworx\RocXolid\Common\Repositories\AttributeValue\Repository as AttributeValueRepository;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * AttributeValue controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Controller extends AbstractCrudController
{
    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse $response
     * @param \Softworx\RocXolid\Common\Repositories\AttributeValueRepository\Repository $repository
     * @param \Softworx\RocXolid\Common\Models\Attribute $attribute
     */
    public function __construct(AjaxResponse $response, AttributeValueRepository $repository, Attribute $attribute)
    {
        parent::__construct($response, $attribute->exists() ? $repository->setAttribute($attribute) : $repository);
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, CrudableModel $attribute_value, AbstractCrudForm $form): array
    {
        $model_viewer_component = $this->getModelViewerComponent();
        $attribute_model_viewer_component = $attribute_value->attribute->getModelViewerComponent();
        $template_name = sprintf('include.%s', $request->_section);

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
        $model_viewer_component = $this->getModelViewerComponent();

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
    protected function destroyNonAjaxResponse(CrudRequest $request, CrudableModel $attribute_value)//: Response
    {
        return redirect($attribute_value->attribute->attributeGroup->getControllerRoute());
    }
}
