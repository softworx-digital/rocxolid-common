<?php

namespace Softworx\RocXolid\Common\Services\Contracts;

// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid service contracts
use Softworx\RocXolid\Services\Contracts\ConsumerService;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Uploadable;

/**
 * Service to handle file uploads.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
interface FileUploadService extends ConsumerService
{
    /**
     * Process upload request.
     * The model serves as a fake filled wtih submitted data to be cloned.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    public function handleFileUploadRequest(CrudRequest $request, Uploadable $model): Uploadable;
}
