<?php

namespace Softworx\RocXolid\Common\Http\Controllers;

use Illuminate\Http\UploadedFile;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid response contracts
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudController;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Uploadable;
// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\FileUploadService;

/**
 * Controller for uploadable models.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
abstract class AbstractUploadController extends AbstractCrudController
{
    /**
     * {@inheritDoc}
     */
    protected $use_ajax_destroy_confirmation = true;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        FileUploadService::class,
    ];

    /**
     * Finish the upload process - close the modal.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @return array
     */
    public function onUploadComplete(CrudRequest $request): array
    {
        $model_viewer_component = $this->getModelViewerComponent();

        return $this->response
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $request->input('_param'))))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function onStoreFormValid(CrudRequest $request, AbstractCrudForm $form)//: Response
    {
        $model = $this->getRepository()->getModel();
        $model = $this->getRepository()
            ->fillModel($model, $form->getFormFieldsValues())
            ->onCreateBeforeSave($form->getFormFieldsValues()); // to set model attribute

        $model = $this->handleUpload($request, $model);

        // return $this->onModelStored($request, $model, $form);
        return $this
            ->replaceModelContainerResponse($request, $model, $form->getParam())
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelUpdated(CrudRequest $request, Crudable $model, AbstractCrudForm $form): CrudController
    {
        // @todo "hotfixed"
        if ($model->isParentPrimary() && !$model->isParentSingle()) {
            $model->parent->{$model->model_attribute}->except($model->getKey())->each(function ($sibling) {
                $sibling->update([
                    'is_model_primary' => 0,
                ]);
            });
        }

        return parent::onModelUpdated($request, $model, $form);
    }

    /**
     * {@inheritDoc}
     */
    protected function successAjaxResponse(CrudRequest $request, Crudable $model, AbstractCrudForm $form): array
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this
            ->replaceModelContainerResponse($request, $model, $form->getParam())
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyAjaxResponse(CrudRequest $request, Crudable $model): array
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this
            ->replaceModelContainerResponse($request, $model, 'destroy-confirm')
            ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm', $model->getKey()))
            ->get();
    }

    /**
     * Do the actual file upload and store the file.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     */
    protected function handleUpload(CrudRequest $request, Uploadable $model): Uploadable
    {
        return $this->fileUploadService()->handleFileUploadRequest($request, $model, function (
            FileUploadService $file_upload_service,
            UploadedFile $uploaded_file,
            Uploadable $uploadable
        ) {
            $this->onUploadableStored($file_upload_service, $uploaded_file, $uploadable);
        });
    }

    /**
     * Generic AJAX response on successful upload or destruction.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $param
     * @return \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse
     */
    protected function replaceModelContainerResponse(CrudRequest $request, Crudable $model, string $param): AjaxResponse
    {
        $model_viewer_component = $model->getModelViewerComponent();

        switch (true) {
            case !$model->isParentSingle():
                return $this->replaceMorphManyResponse($request, $model, $model_viewer_component, $param);
            case $model->exists() && !$model->trashed():
                return $this->replaceMorphOneResponse($request, $model, $model_viewer_component, $param);
            default:
                return $this->replaceMorphOneByPlaceholderResponse($request, $model, $model_viewer_component, $param);
        }
    }

    /**
     * AJAX response to replace single image with a placeholder.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param \Softworx\RocXolid\Common\Components\ModelViewers\CrudModelViewer $model_viewer_component
     * @param string $param
     */
    protected function replaceMorphOneByPlaceholderResponse(CrudRequest $request, Crudable $model, CrudModelViewer $model_viewer_component, string $param): AjaxResponse
    {
        $assignment = $this->getTemplateRelationAssignment($model) + [
            'related' => $model->parent,
            'placeholder' => $this->getModelPlaceholder($model, $param),
        ];

        return $this->response
            ->replace(
                $model_viewer_component->getDomId(md5(get_class($model->parent)), $model->parent->getKey(), $model->model_attribute),
                $model_viewer_component->fetch($this->getTemplateNameForPlaceholder($model, $param), $assignment)
            );
    }

    /**
     * AJAX response to replace single image with new content.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param \Softworx\RocXolid\Common\Components\ModelViewers\CrudModelViewer $model_viewer_component
     * @param string $param
     */
    protected function replaceMorphOneResponse(CrudRequest $request, Crudable $model, CrudModelViewer $model_viewer_component, string $param): AjaxResponse
    {
        $assignment = $this->getTemplateRelationAssignment($model);

        return $this->response
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $param)))
            ->replace(
                $model_viewer_component->getDomId(md5(get_class($model->parent)), $model->parent->getKey(), $model->model_attribute),
                $model_viewer_component->fetch($this->getTemplateNameForMorpOne($model, $param), $assignment)
            );
    }

    /**
     * AJAX response to replace the image gallery with new content.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param \Softworx\RocXolid\Common\Components\ModelViewers\CrudModelViewer $model_viewer_component
     * @param string $param
     */
    protected function replaceMorphManyResponse(CrudRequest $request, Crudable $model, CrudModelViewer $model_viewer_component, string $param): AjaxResponse
    {
        $assignment = $this->getTemplateRelationAssignment($model);

        return $this->response
            ->replace(
                $model_viewer_component->getDomId(md5(get_class($model->parent)), $model->parent->getKey(), $model->model_attribute, 'content'),
                $model_viewer_component->fetch($this->getTemplateNameForMorphMany($model, $param), $assignment)
            );
    }

    /**
     * Retrieve the template name to be displayed as a placeholder when the model does not exist.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $param
     * @return string
     */
    protected function getTemplateNameForPlaceholder(Crudable $model, string $param): string
    {
        return 'related.unavailable';
    }

    /**
     * Retrieve the template name to be displayed for MorphOne relation.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $param
     * @return string
     */
    protected function getTemplateNameForMorpOne(Crudable $model, string $param): string
    {
        return 'related.show';
    }

    /**
     * Retrieve the template name to be displayed for MorphMany relation.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $param
     * @return string
     */
    protected function getTemplateNameForMorphMany(Crudable $model, string $param): string
    {
        return 'related-many.items';
    }

    /**
     * Obtain model relation template assignment.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @return array
     */
    protected function getTemplateRelationAssignment(Crudable $model): array
    {
        return $this->getParentTemplateRelationAssignment($model) + [
            'attribute' => $model->model_attribute,
            'relation' => 'parent',
        ];
    }

    /**
     * Obtain parent model relation template assignment.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @return array
     */
    abstract protected function getParentTemplateRelationAssignment(Crudable $model): array;

    /**
     * Action to take after uploaded file is stored.
     *
     * @param \Softworx\RocXolid\Common\Services\Contracts\FileUploadService $file_upload_service
     * @param \Illuminate\Http\UploadedFile $uploaded_file
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $uploadable
     * @return \Softworx\RocXolid\Http\Controllers\Contracts\Crudable
     */
    abstract protected function onUploadableStored(FileUploadService $file_upload_service, UploadedFile $uploaded_file, Uploadable $uploadable): CrudController;

    /**
     * Placeholder image filename to display for unavailable models.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $param
     * @return string|null
     */
    abstract protected function getModelPlaceholder(Crudable $model, string $param): ?string;
}
