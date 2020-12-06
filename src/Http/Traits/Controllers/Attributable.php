<?php

namespace Softworx\RocXolid\Common\Http\Traits\Controllers;

// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as AbstractCrudForm;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\AttributeModelViewer;
// rocXolid common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable as AttributableModel;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AttributeModel\Controller as AttributeModelController;
// rocXolid common forms
use Softworx\RocXolid\Common\Models\Forms\AttributeModel\General as AttributeModelForm;
// rocXolid common models
use Softworx\RocXolid\Common\Models\AttributeGroup;

/**
 * Trait to enable controller to handle dynamic model attributes assignment.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo: make this to boot consecutive routes
 * @todo: subject to refactoring - use pivot instead of 'foreign' controller
 */
trait Attributable
{
    /**
     * {@inheritDoc}
     */
    public function modelAttributes(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null)
    {
        $attribute_model_viewer_component = $this->makeAttributeModelViewerComponent($request, $model, $attribute_group);

        return $this->response
            ->modal($attribute_model_viewer_component->fetch('modal.attributes'))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    public function modelAttributesStore(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null)
    {
        $attribute_model_form = $this->makeAttributeModelForm($request, $model, $attribute_group);

        return $attribute_model_form->submit()->isValid()
            ? $this->onUpdateAttributeModelFormValid($request, $model, $attribute_group, $attribute_model_form)
            : $this->onUpdateAttributeModelFormInvalid($request, $model, $attribute_group, $attribute_model_form);
    }

    /**
     * Obtain response to valid AttributeModelForm submission.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $form
     */
    protected function onUpdateAttributeModelFormValid(CrudRequest $request, AttributableModel $model, AttributeGroup $attribute_group, AbstractCrudForm $attribute_model_form)//: Response
    {
        $model = $this->makeAttributeModelController($request, $model, $attribute_group)->getRepository()->updateModel($model, $attribute_model_form->getFormFieldsValues());
        $attribute_model_viewer_component = $this->makeAttributeModelViewerComponent($request, $model, $attribute_group);
        $attribute_group_viewer_component = $attribute_group->getModelViewerComponent();

        return $this->response
            ->notifySuccess($attribute_model_viewer_component->translate('text.updated'))
            ->replace($attribute_group_viewer_component->getDomId('dynamic-attribute-group', $attribute_group->getKey()), $attribute_group_viewer_component->fetch('related.panel', [
                'attributable' => $model,
            ]))
            ->modalClose($attribute_model_viewer_component->getDomId(sprintf('modal-%s', $attribute_model_form->getParam())))
            ->get();
    }

    /**
     * Obtain response to invalid AttributeModelForm submission.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group
     * @param \Softworx\RocXolid\Forms\AbstractCrudForm $attribute_model_form
     */
    protected function onUpdateAttributeModelFormInvalid(CrudRequest $request, AttributableModel $model, AttributeGroup $attribute_group, AbstractCrudForm $attribute_model_form)//: Response
    {
        $attribute_model_controller = $this->makeAttributeModelController($request, $model, $attribute_group);
        $attribute_model_form_component = $attribute_model_controller->getFormComponent($attribute_model_form);

        return $this->response
            ->notifyError($attribute_model_form_component->translate('text.form-error'))
            ->replace($attribute_model_form_component->getDomId('fieldset'), $attribute_model_form_component->fetch('include.fieldset'))
            ->get();
    }

    /**
     * Obtain AttributeModelController to set AttributeValues of given AttributeGroup to an AttributableModel.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup|null $attribute_group
     * @return \Softworx\RocXolid\Common\Http\Controllers\AttributeModel\Controller
     */
    private function makeAttributeModelController(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null): AttributeModelController
    {
        return app(AttributeModelController::class, [
            'attributable_model' => $model,
            'attribute_group' => $attribute_group,
        ]);
    }

    /**
     * Obtain AttributeModel form to set AttributeValues of given AttributeGroup to an AttributableModel.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup|null $attribute_group
     * @return \Softworx\RocXolid\Common\Models\Forms\AttributeModel\General
     */
    private function makeAttributeModelForm(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null): AttributeModelForm
    {
        return $this->makeAttributeModelController($request, $model, $attribute_group)
            ->getForm($request, $model)
            ->setCustomOptions([
                'route-action' => $this->getRoute('modelAttributesStore', $model),
            ]);
    }

    /**
     * Obtain AttributeValueViewer form to set AttributeValues of given AttributeGroup to an AttributableModel.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Common\Models\Contracts\Attributable $model
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup|null $attribute_group
     * @return \Softworx\RocXolid\Common\Components\ModelViewers\AttributeModelViewer
     */
    private function makeAttributeModelViewerComponent(CrudRequest $request, AttributableModel $model, ?AttributeGroup $attribute_group = null): AttributeModelViewer
    {
        $attribute_model_controller = $this->makeAttributeModelController($request, $model, $attribute_group);
        $attribute_model_form = $this->makeAttributeModelForm($request, $model, $attribute_group);

        return $attribute_model_controller->getModelViewerComponent($model, $attribute_model_controller->getFormComponent($attribute_model_form));
    }
}
