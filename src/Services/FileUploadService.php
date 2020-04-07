<?php

namespace Softworx\RocXolid\Common\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid service contracts
use Softworx\RocXolid\Contracts\ServiceConsumer;
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
class FileUploadService implements FileUploadServiceContract, ConsumerService
{
    /**
     * Storage location directory.
     */
    const STORAGE_DIR = 'app';

    /**
     * Storage location subdirectory.
     */
    const STORAGE_SUBDIR = 'files';

    /**
     * Service consumer reference.
     *
     * @var \Softworx\RocXolid\Common\Http\Controllers\AbstractController
     * @todo: maybe some uploadish interface
     */
    protected $consumer;

    /**
     * {@inheritDoc}
     */
    public function setConsumer(ServiceConsumer $consumer): ConsumerService
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * Handle file upload and set appropriate data to model.
     *
     * @param \Illuminate\Http\UploadedFile $uploaded_file
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @param \Closure|null $callback
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    public function handleUpload(UploadedFile $uploaded_file, Uploadable $model, ?\Closure $callback = null): Uploadable
    {
        $storage_path = $this->storeUploadedFile($uploaded_file, $model);

        $model->setUploadData($uploaded_file, $storage_path);

        if (is_callable($callback)) {
            $callback($model);
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
        $path = sprintf('%s/%s', static::STORAGE_SUBDIR, $model->getRelativeUploadPath());
        $name = sprintf('%s.%s', Str::random(40), $uploaded_file->getClientOriginalExtension()); // keep extension (was saving svg as txt)

        return $uploaded_file->storeAs($path, $name);
    }
}
