<?php

namespace Softworx\RocXolid\Common\Http\Controllers\File;

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
use Softworx\RocXolid\Common\Components\ModelViewers\FileViewer;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\FileUploadService;

/**
 * File controller.
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
    protected $use_ajax_destroy_confirmation = true;

    /**
     * {@inheritDoc}
     */
    protected static $model_viewer_type = FileViewer::class;

    /**
     * Return the file content making the file accessible per route.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request Incoming request.
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $file
     * @return void
     */
    public function get(CrudRequest $request, Crudable $file): Response
    {
        try {
            return response($file->content(), 200)
                ->header('Content-Type', $file->mime_type);
        } catch (FileNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Force the file download prompt.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request Incoming request.
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $file
     * @return void
     */
    public function download(CrudRequest $request, Crudable $file): Response
    {
        try {
            return $this
                ->get($request, $file)
                ->header('Content-Disposition', sprintf('attachment; filename="%s"', $file->attachment_filename));
        } catch (FileNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function onUploadableStored(FileUploadService $file_upload_service, UploadedFile $uploaded_file, Uploadable $model): CrudController
    {
        $model->save();

        $model->parent->onFileUpload($model, $this);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function onModelDestroyed(CrudRequest $request, Crudable $model): CrudController
    {
        $model->parent->onFileDestroyed($model, $this);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function destroyNonAjaxResponse(CrudRequest $request, Crudable $model)//: Response
    {
        return redirect($model->parent->deleteFileRedirectPath());
    }

    /**
     * {@inheritDoc}
     */
    protected function getModelPlaceholder(Crudable $model, string $param): ?string
    {
        return null;
    }
}
