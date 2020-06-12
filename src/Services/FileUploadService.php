<?php

namespace Softworx\RocXolid\Common\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid service traits
use Softworx\RocXolid\Services\Traits\HasServiceConsumer;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Uploadable;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\FileUploadService as FileUploadServiceContract;

/**
 * Service to handle file uploads.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class FileUploadService implements FileUploadServiceContract
{
    use HasServiceConsumer;

    /**
     * Storage location directory.
     */
    const STORAGE_DIR = 'app';

    /**
     * {@inheritDoc}
     */
    public function handleFileUploadRequest(CrudRequest $request, Uploadable $model, ?\Closure $callback = null): Uploadable
    {
        collect($request->file())->each(function ($data) use (&$model, $callback) {
            collect($data)->each(function ($uploaded_file, $field_name) use (&$model, $callback) {
                $this->handleUploadedFile($uploaded_file, $model, $callback);
            });
        });

        return $model;
    }

    /**
     * Handle file upload and set appropriate data to model.
     *
     * @param \Illuminate\Http\UploadedFile $uploaded_file
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @param \Closure|null $callback
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     * @throws \RuntimeException
     */
    protected function handleUploadedFile(UploadedFile $uploaded_file, Uploadable $model, ?\Closure $callback = null): Uploadable
    {
        $storage_path = $this->storeUploadedFile($uploaded_file, $model);

        $model
            ->setStorageData($storage_path)
            ->setUploadData($uploaded_file);

        if ($model->parent->{$model->model_attribute}() instanceof MorphOne) {
            $model = $this->onMorphOneModelUploaded($model);
        } elseif ($model->parent->{$model->model_attribute}() instanceof MorphMany) {
            $model = $this->onMorphManyModelUploaded($model);
        } else {
            throw new \RuntimeException(sprintf(
                'Invalid model relation type [%s] for [%s]->[%s]',
                get_class($model->parent->{$model->model_attribute}()),
                get_class($model->parent), $model->model_attribute)
            );
        }

        if (is_callable($callback)) {
            $callback($this, $uploaded_file, $model);
        }

        return $model;
    }

    /**
     * Actually stores the uploaded file to storage location.
     *
     * @param \Illuminate\Http\UploadedFile $uploaded_file
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return string
     */
    protected function storeUploadedFile(UploadedFile &$uploaded_file, Uploadable $model): string
    {
        $name = sprintf('%s.%s', Str::random(40), $uploaded_file->getClientOriginalExtension()); // keep extension (was saving svg as txt)

        return $uploaded_file->storeAs($model->getRelativeUploadPath(), $name);
    }

    /**
     * Handle MorphOne model relation.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    protected function onMorphOneModelUploaded(Uploadable $model): Uploadable
    {
        if ($model->parent->{$model->model_attribute}()->exists()) {
            $model->parent->{$model->model_attribute}->delete();
        }

        return $model;
    }

    /**
     * Handle MorphMany model relation.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    protected function onMorphManyModelUploaded(Uploadable $model): Uploadable
    {
        // $model->is_model_primary = ($model->parent->{$model->model_attribute}()->count() == 0);

        return $model;
    }
}
