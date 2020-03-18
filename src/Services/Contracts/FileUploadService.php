<?php

namespace Softworx\RocXolid\Common\Services\Contracts;

use Illuminate\Http\UploadedFile;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Uploadable;

/**
 * Service to handle file uploads.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
interface FileUploadService
{
    /**
     * Handle file upload assigned to model.
     *
     * @param \Illuminate\Http\UploadedFile $uploaded_file
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    public function handleUpload(UploadedFile $uploaded_file, Uploadable $model): Uploadable;
}
