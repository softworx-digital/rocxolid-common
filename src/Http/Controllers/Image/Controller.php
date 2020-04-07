<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Image;

use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// relations
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudController;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\ImageViewer;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\ImageUploadService;

/**
 * Image controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo: refactor together with image service
 */
class Controller extends AbstractCrudController
{
    protected static $model_viewer_type = ImageViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        ImageUploadService::class,
    ];

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        // 'onUploadComplete' => 'upload',
    ];

    /**
     * Return the image content making the image accessible per route.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request Incoming request.
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $image
     * @param string|null $size
     * @return void
     */
    public function get(CrudRequest $request, Crudable $image, ?string $size = null)
    {
        try {
            return response($image->content($size), 200)->header('Content-Type', $image->mime_type);
        } catch (FileNotFoundException $e) {
            abort(404);
        }
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

        $model = $this->imageUploadService()->handleFileinputUpload($request, $model);

        // return $this->onModelStored($request, $model, $form);
        return $this
            ->replaceImageContainerResponse($request, $model, $form->getParam())
            ->get();
    }

    /**
     * Finish the upload process - close the modal.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     */
    public function onUploadComplete(CrudRequest $request)
    {
        $model_viewer_component = $this->getModelViewerComponent();

        return $this->response
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $request->input('_param'))))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelUpdated(CrudRequest $request, Crudable $model, AbstractCrudForm $form): CrudController
    {
        // @todo: "hotfixed"
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
    protected function successAjaxResponse(CrudRequest $request, Crudable $model, AbstractCrudForm $form)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this
            ->replaceImageContainerResponse($request, $model, $form->getParam())
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $form->getParam())))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyAjaxResponse(CrudRequest $request, Crudable $model)
    {
        $model_viewer_component = $this->getModelViewerComponent($model);

        return $this
            ->replaceImageContainerResponse($request, $model, 'destroy-confirm')
            ->modalClose($model_viewer_component->getDomId('modal-destroy-confirm'))
            ->get();
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyNonAjaxResponse(CrudRequest $request, Crudable $model)
    {
        return redirect($model->parent->deleteImageRedirectPath());
    }

    /**
     * Generic AJAX response on successful image upload or destruction.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $param
     */
    private function replaceImageContainerResponse(CrudRequest $request, Crudable $model, string $param)
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
     * AJAX response to replace the image gallery with new content.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param \Softworx\RocXolid\Common\Components\ModelViewers\ImageViewer $model_viewer_component
     * @param string $param
     */
    private function replaceMorphManyResponse(CrudRequest $request, Crudable $model, ImageViewer $model_viewer_component, string $param)
    {
        return $this->response
            ->replace(
                $model_viewer_component->getDomId($model->parent->getKey(), $model->model_attribute, 'images'),
                $model_viewer_component->fetch('gallery.images', $this->getTemplateRelationAssignment($model))
            );
    }

    /**
     * AJAX response to replace single image with new content.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param \Softworx\RocXolid\Common\Components\ModelViewers\ImageViewer $model_viewer_component
     * @param string $param
     */
    private function replaceMorphOneResponse(CrudRequest $request, Crudable $model, ImageViewer $model_viewer_component, string $param)
    {
        return $this->response
            ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $param)))
            ->replace(
                $model_viewer_component->getDomId($model->model_attribute),
                $model_viewer_component->fetch('related.show', $this->getTemplateRelationAssignment($model))
            );
    }

    /**
     * AJAX response to replace single image with a placeholder.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param \Softworx\RocXolid\Common\Components\ModelViewers\ImageViewer $model_viewer_component
     * @param string $param
     */
    private function replaceMorphOneByPlaceholderResponse(CrudRequest $request, Crudable $model, ImageViewer $model_viewer_component, string $param)
    {
        $assignment = $this->getTemplateRelationAssignment($model) + [
            'related' => $model->parent,
            'placeholder' => $model->parent->getImagePlaceholder(),
        ];

        return $this->response
            ->replace(
                $model_viewer_component->getDomId($model->model_attribute),
                $model_viewer_component->fetch('related.unavailable', $assignment)
            );
    }

    /**
     * Obtain model relation template assignment.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @todo: find nicer approach
     */
    private function getTemplateRelationAssignment(Crudable $model)
    {
        return [
            'attribute' => $model->model_attribute,
            'relation' => 'parent',
        ];
    }
}
