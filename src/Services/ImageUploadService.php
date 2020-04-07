<?php

namespace Softworx\RocXolid\Common\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// third party
use Intervention\Image\Exception\NotReadableException;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Uploadable;
use Softworx\RocXolid\Models\Contracts\Resizable;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\ImageUploadService as ImageUploadServiceContract;
// rocXolid common services
use Softworx\RocXolid\Common\Services\FileUploadService;

/**
 * Service to handle image uploads.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo: refactor
 */
class ImageUploadService extends FileUploadService implements ImageUploadServiceContract
{
    const STORAGE_SUBDIR = 'images';

    /**
     * Process upload request.
     * The model serves as a fake filled wtih submitted data to be cloned.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     * @todo: make this FileService::handleUpload() override and process further execution somewhere else
     */
    public function handleFileinputUpload(CrudRequest $request, Uploadable $model): Uploadable
    {
        collect($request->file())->each(function ($data) use (&$model) {
            collect($data)->each(function ($uploaded_file, $field_name) use (&$model) {
                $image = $model->replicate();

                $this->handleUpload($uploaded_file, $image, function($image) use (&$model) {
                    $image = $this->handleResize($image);

                    if ($image->parent->{$image->model_attribute}() instanceof MorphOne) {
                        $image = $this->onMorphOneImageUploaded($image);
                    } elseif ($image->parent->{$image->model_attribute}() instanceof MorphMany) {
                        $image = $this->onMorphManyImageUploaded($image);
                    } else {
                        throw new \RuntimeException(sprintf('Invalid image relation type [%s] for [%s]->[%s]', get_class($image->parent->{$image->model_attribute}()), get_class($image->parent), $image->model_attribute));
                    }

                    $image->save();
                    $image->parent->onImageUpload($image, $this->consumer);
                    // we'll replace the model with the uploaded and saved image
                    // to return the persisted model to pass it to the response
                    $model = $image;
                });
            });
        });

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    public function handleResize(Resizable $model): Resizable
    {
        try {
            $this->saveResized($model);
        } catch (NotReadableException $e) {
            $this->onFileNotReadable($model);
        }

        return $model;
    }

    /**
     * Process model image dimensions definition, resize the physical image according to the settings,
     * save to the file in appropriate subfolder.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Resizable $model
     * @return \Softworx\RocXolid\Common\Services\Contracts\ImageUploadService
     */
    protected function saveResized(Resizable $model): ImageUploadServiceContract
    {
        $source_path = $model->getStoragePath();

        $intervention_image = \InterventionImage::make($model->getStoragePath());
        $sizes = [
            'original' => [
                'width' => $intervention_image->width(),
                'height' => $intervention_image->height(),
                'ratio' => $intervention_image->width() / $intervention_image->height(),
            ]
        ];

        $model->getDimensions()->each(function ($options, $directory) use ($model, $sizes) {
            $intervention_image = \InterventionImage::make($model->getStoragePath());
            $target_directory = dirname($model->getStoragePath($directory));

            if (!File::exists($target_directory) && !File::makeDirectory($target_directory)) {
                throw new \RuntimeException(sprintf('Cannot create directory: %s', $target_directory));
            }

            $w = $options['width'] ?? round($options['height'] / $sizes['original']['ratio']);
            $h = $options['height'] ?? round($options['width'] / $sizes['original']['ratio']);

            collect($options['method'])->each(function ($method) use (&$intervention_image, $options, $w, $h) {
                if (in_array($method, [ 'resize', 'fit' ])) {
                    $intervention_image->$method($w, $h, function ($constraint) use ($options) {
                        if (isset($options['constraints'])) {
                            foreach ($options['constraints'] as $constraint_method) {
                                $constraint->$constraint_method();
                            }
                        }
                    });
                } else {
                    $intervention_image->$method($w, $h);
                }
            });

            $intervention_image->save(sprintf('%s/%s', $target_directory, basename($model->getStoragePath())));
        });

        $model->setResizeData(collect($sizes));

        return $this;
    }

    /**
     * Fallback when it is not possible to make intervention image.
     * Copy the original file to subfolders dedicated for each size.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Resizable $model
     * @return \Softworx\RocXolid\Common\Services\Contracts\ImageUploadService
     */
    protected function onFileNotReadable(Resizable $model): ImageUploadServiceContract
    {
        $sizes = [
            'original' => [
                'width' => 'unknown',
                'height' => 'unknown',
            ]
        ];

        $model->getDimensions()->each(function ($options, $directory) use ($model, $sizes) {
            $target_directory = dirname($model->getStoragePath($directory));

            if (!File::exists($target_directory) && !File::makeDirectory($target_directory)) {
                throw new \RuntimeException(sprintf('Cannot create directory: %s', $target_directory));
            }

            Storage::copy($model->getStoragePath(), sprintf('%s/%s', $target_directory, basename($model->getStoragePath())));
        });

        $model->setResizeData(collect($sizes));

        return $this;
    }

    /**
     * Handle MorphOne image relation.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    protected function onMorphOneImageUploaded(Uploadable $model): Uploadable
    {
        if ($model->parent->{$model->model_attribute}()->exists()) {
            $model->parent->{$model->model_attribute}->delete();
        }

        return $model;
    }

    /**
     * Handle MorphMany image relation.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Uploadable $model
     * @return \Softworx\RocXolid\Models\Contracts\Uploadable
     */
    protected function onMorphManyImageUploaded(Uploadable $model): Uploadable
    {
        $model->is_model_primary = ($model->parent->{$model->model_attribute}()->count() == 0);

        return $model;
    }
}
