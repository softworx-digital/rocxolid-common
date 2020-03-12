<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Image;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// @todo
use Softworx\RocXolid\Http\Requests\CrudRequest;
use Softworx\RocXolid\Components\Forms\FormField;
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\Common\Repositories\Image\Repository;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as CrudModelViewerComponent;
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

    public function getModelViewerComponent(CrudableModel $model): CrudModelViewerComponent
    {
        return ImageViewer::build($this, $this)
            ->setModel($model)
            ->setController($this);
    }

    public function get(CrudRequest $request, CrudableModel $image, $size = null)
    {
        try {
            return response($image->content($size), 200)->header('Content-Type', $image->mime_type);
        } catch (FileNotFoundException $e) {
            abort(404);
        }
    }

    public function update(CrudRequest $request, CrudableModel $model)//: Response
    {
        $this->setModel($model);

        $repository = $this->getRepository($this->getRepositoryParam($request));

        $form = $repository->getForm($this->getFormParam($request));
        $form
            //->adjustUpdate($request)
            ->adjustUpdateBeforeSubmit($request)
            ->submit();

        if ($form->isValid()) {
            $attribute = $this->getModel()->model_attribute;

            if ($request->has('_data.is_model_primary') && $request->input('_data.is_model_primary')) {
                $images = ($this->getModel()->parent->$attribute instanceof Collection) ? $this->getModel()->parent->$attribute : [ $this->getModel()->parent->$attribute ];

                foreach ($images as $image) {
                    $image->is_model_primary = 0;
                    $image->save();
                }
            }

            $repository->updateModel($form->getFormFieldsValues()->toArray(), $this->getModel(), 'update');

            return $this->getParentUpdateResponse($attribute);
        } else {
            return $this->errorResponse($request, $repository, $form, 'edit');
        }
    }

    protected function destroyResponse(CrudRequest $request, CrudableModel $model)
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
}
