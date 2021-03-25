<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Image;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid response contracts
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid controller contracts
use Softworx\RocXolid\Http\Controllers\Contracts\Crudable as CrudController;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Uploadable;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractUploadController;
// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\ImageViewer;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\FileUploadService;
use Softworx\RocXolid\Common\Services\Contracts\ImageProcessService;

/**
 * Image controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Controller extends AbstractUploadController
{
    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = ImageViewer::class;

    /**
     * {@inheritDoc}
     */
    protected $extra_services = [
        FileUploadService::class,
        ImageProcessService::class,
    ];

    /**
     * Return the image content making the image accessible per route.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request Incoming request.
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $image
     * @param string|null $size
     * @return \Illuminate\Http\Response
     */
    public function get(CrudRequest $request, Crudable $image, ?string $size = null): Response
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
    protected function onUploadableStored(FileUploadService $file_upload_service, UploadedFile $uploaded_file, Uploadable $model): CrudController
    {
        $model = $this->imageProcessService()->handleResize($model);
        $model->save();

        $model->parent->onImageUpload($model, $this);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyNonAjaxResponse(CrudRequest $request, Crudable $model)//: Response
    {
        return redirect($model->parent->deleteImageRedirectPath());
    }

    /**
     * {@inheritDoc}
     */
    protected function getTemplateNameForMorphMany(Crudable $model, string $param): string
    {
        return 'gallery.images';
    }

    /**
     * {@inheritDoc}
     */
    protected function getModelPlaceholder(Crudable $model, string $param): ?string
    {
        return $model->parent->getImagePlaceholder();
    }
}
