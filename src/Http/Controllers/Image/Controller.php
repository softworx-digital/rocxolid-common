<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid repositorie contracts
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid common repositories
use Softworx\RocXolid\Common\Repositories\Image\Repository;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\ImageViewer;

/**
 *
 */
class Controller extends AbstractCrudController
{
    protected static $model_class = Image::class;

    protected static $repository_class = Repository::class;

    /**
     * {@inheritDoc}
     */
    protected $form_mapping = [
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'edit.model' => 'update-in-model',
        'update.model' => 'update-in-model',
    ];

    public function getModelViewerComponent(Crudable $model): CrudModelViewerComponent
    {
        return ImageViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    /**
     * Return the image content making the image accessible per route.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
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
    protected function successResponse(CrudRequest $request, RepositoryContract $repository, AbstractCrudForm $form, Crudable $model, string $action)
    {
        if ($request->ajax()) {
            $model_viewer_component = $model->getModelViewerComponent();
            $parent_method = sprintf('onImage%s', Str::studly($action));

            if (method_exists($model->parent->getCrudController(), $parent_method)) {
                return $model->parent->getCrudController()->{$parent_method}($request, $model->parent);
            }

            if ($model->parent->{$model->model_attribute}() instanceof MorphMany) {
                $dom_id = $model_viewer_component->getDomId($model->model_attribute, 'images');
                $template = 'gallery.images';
            } else {
                $dom_id = $model_viewer_component->getDomId($model->model_attribute);
                $template = 'related.show';
            }

            return $this->response
                ->notifySuccess($model_viewer_component->translate('text.updated'))
                ->replace($dom_id, $model_viewer_component->fetch($template, [
                    'attribute' => $model->model_attribute,
                    'relation' => 'parent'
                ])) // @todo: hardcoded, ugly
                ->modalClose($model_viewer_component->getDomId(sprintf('modal-%s', $action)))
                ->get();
        } else {
            return parent::successResponse($request, $repository, $form, $model, $action);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyResponse(CrudRequest $request, Crudable $model)
    {
        $attribute = $this->getModel()->model_attribute;

        if ($request->ajax()) {
            // return $this->response->redirect($model->parent->getControllerRoute('show'))->get();
            return $this->getParentUpdateResponse($attribute);
        } else {
            // return redirect($model->parent->getControllerRoute('show'));
            return redirect($model->parent->deleteImageRedirectPath());
        }
    }

    /*
    protected function getParentUpdateResponse(string $model_attribute)
    {
        $model_viewer_component = $this->getModelViewerComponent($this->getModel());

        $parent_controller = app($this->getModel()->parent->getControllerClass());
        $parent_controller->setModel($this->getModel()->parent);

        $parent_image_upload_component = $parent_controller->getImageUploadFormComponent();

        if ($this->getModel()->parent->$model_attribute() instanceof MorphOne) {
            $parent_image_upload_component = $parent_controller->getImageUploadFormComponent();
        } elseif ($this->getModel()->parent->$model_attribute() instanceof MorphMany) {
            $parent_image_upload_component = $parent_controller->getGalleryUploadFormComponent();
        }

        return $this->response
            ->replace($parent_image_upload_component->getOption('id'), $parent_image_upload_component->fetch('upload'))
            ->modalClose($model_viewer_component->getDomId('modal-update'))
            ->get();
    }
    */
}
