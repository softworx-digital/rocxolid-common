<?php

namespace Softworx\RocXolid\Common\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// third party
use Intervention\Image\Exception\NotReadableException;
// rocXolid model contracts
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
 */
class ImageUploadService extends FileUploadService implements ImageUploadServiceContract
{
    const STORAGE_SUBDIR = 'images';

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
}
