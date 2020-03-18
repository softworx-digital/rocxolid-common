<?php

namespace Softworx\RocXolid\Common\Repositories\Image;

use Illuminate\Http\UploadedFile;
// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid repositories
use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\ImageUploadService;

/**
 *
 */
class Repository extends AbstractCrudRepository
{
    protected $image_upload_service;

    protected $columns = [];

    public function __construct(ImageUploadService $image_upload_service)
    {
        $this->image_upload_service = $image_upload_service;
    }

    /**
     * Upload the image file and assign it to specified resource.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Crudable $model
     * @param string $action
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     */
    protected function beforeModelSave(CrudableModel $model, string $action): CrudableModel
    {
        switch ($action) {
            case 'create':
                return $this->handleCreate($model, $action);
            case 'update':
                return $this->handleUpdate($model, $action);
            default:
                throw new \InvalidArgumentException(sprintf('Unsupported action: %s', $action));
        }
    }

    private function handleCreate(CrudableModel $model, string $action): CrudableModel
    {
        $image = $model;

        foreach ($this->request->file() as $data) {
            foreach ($data as $field_name => $data_file) {
                // foreach ($data_files as $data_file) { // if array is being uploaded
                    $image = $this->image_upload_service->handleUpload($data_file, $image);
                    $image = $this->image_upload_service->handleResize($image);

                    if ($image->parent->{$image->model_attribute}() instanceof MorphOne) {
                        if ($image->parent->{$image->model_attribute}()->exists()) {
                            $image->parent->{$image->model_attribute}->delete();
                        }
                    } elseif ($image->parent->{$image->model_attribute}() instanceof MorphMany) {
                        //
                    } else {
                        throw new \RuntimeException(sprintf('Invalid image relation type [%s] for [%s]->[%s]', get_class($image->parent->{$image->model_attribute}()), get_class($image->parent), $image->model_attribute));
                    }

                    $image->is_model_primary = ($image->parent->{$image->model_attribute}()->count() == 0);
                    $image->save();

                    $image->parent->onImageUpload($image, $this->getController());
                // }
            }
        }

        return $image;
    }

    private function handleUpdate(CrudableModel $model, string $action): CrudableModel
    {
        $model->parent->{$model->model_attribute}->where($model->getKeyName(), '!=', $model->getKey())->each(function($sibling) {
            if ($sibling->is_model_primary) {
                $sibling->update([
                    'is_model_primary' => 0,
                ]);
            }
        });

        $model->parent->load($model->model_attribute);

        return $model;
    }
}
