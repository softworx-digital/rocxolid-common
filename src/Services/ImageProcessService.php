<?php

namespace Softworx\RocXolid\Common\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// third party
use Intervention\Image\Exception\NotReadableException;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Resizable;
// rocXolid common service contracts
use Softworx\RocXolid\Common\Services\Contracts\ImageProcessService as ImageProcessServiceContract;

/**
 * Service to handle image post .
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class ImageProcessService implements ImageProcessServiceContract
{
    const STORAGE_SUBDIR = 'images';

    /**
     * {@inheritDoc}
     */
    /*
    public function handleFileUpload(CrudRequest $request, Uploadable $model): Uploadable
    {
        collect($request->file())->each(function ($data) use (&$model) {
            collect($data)->each(function ($uploaded_file, $field_name) use (&$model) {
                $image = $model->replicate();

                $this->handleUploadedFile($uploaded_file, $image, function($image) use (&$model) {
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
    */

    /**
     * {@inheritDoc}
     */
    public function handleResize(Resizable $model): Resizable
    {
        try {
            $this->resize($model);
        } catch (NotReadableException $e) {
            $this->onFileNotReadable($model);
        }

        return $model;
    }

    /**
     * Process model image dimensions definition, resize the physical image according to the settings.
     * Subsequently store the processed resized image in appropriate subfolder.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Resizable $model
     * @return \Softworx\RocXolid\Common\Services\Contracts\ImageProcessService
     * @throws \Intervention\Image\Exception\NotReadableException
     * @todo refactor?
     */
    protected function resize(Resizable $model): ImageProcessServiceContract
    {
        $physical = $model->getPhysicalImage();

        $sizes = [
            'original' => [
                'width' => $physical->width(),
                'height' => $physical->height(),
                'ratio' => $physical->width() / $physical->height(),
            ]
        ];

        $model->getDimensions()->each(function ($options, $directory) use ($model, $sizes) {
            $physical = $model->getPhysicalImage();
            $target_directory = dirname($model->getStoragePath($directory));

            if (!File::exists($target_directory) && !File::makeDirectory($target_directory)) {
                throw new \RuntimeException(sprintf('Cannot create directory: %s', $target_directory));
            }

            $w = $options['width'] ?? round($options['height'] / $sizes['original']['ratio']);
            $h = $options['height'] ?? round($options['width'] / $sizes['original']['ratio']);

            collect($options['method'])->each(function ($method) use (&$physical, $options, $w, $h) {
                if (in_array($method, [ 'resize', 'fit' ])) {
                    $physical->$method($w, $h, function ($constraint) use ($options) {
                        if (isset($options['constraints'])) {
                            foreach ($options['constraints'] as $constraint_method) {
                                $constraint->$constraint_method();
                            }
                        }
                    });
                } else {
                    $physical->$method($w, $h);
                }
            });

            $physical->save(sprintf('%s/%s', $target_directory, basename($model->getStoragePath())));
        });

        $model->setResizeData(collect($sizes));

        return $this;
    }

    /**
     * Fallback when it is not possible to make intervention image.
     * Copy the original file to subfolders dedicated for each size.
     *
     * @param \Softworx\RocXolid\Models\Contracts\Resizable $model
     * @return \Softworx\RocXolid\Common\Services\Contracts\ImageProcessService
     * @throws \RuntimeException
     */
    protected function onFileNotReadable(Resizable $model): ImageProcessServiceContract
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
}
