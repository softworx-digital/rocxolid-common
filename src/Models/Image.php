<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Uploadable;
use Softworx\RocXolid\Models\Contracts\Resizable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\File;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

/**
 * @todo refactor?
 */
class Image extends File implements Resizable
{
    /**
     * {@inheritDoc}
     */
    const STORAGE_SUBDIR = 'images';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_model_primary',
        //'name',
        'alt',
        'description',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
    ];

    /**
     * {@inheritDoc}
     */
    public function resolvePolymorphUserModel()
    {
        return User::class;
    }

    /**
     * Get base-64 encoded file content.
     *
     * @param string $size
     * @return string
     */
    public function base64($size = 'icon'): string
    {
        try {
            return sprintf('data:%s;base64,%s', $this->getMimeType(), base64_encode($this->content($size)));
        } catch (\Exception $e) {
            return config('rocXolid.common.general.base64-image-preloader');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadData(UploadedFile $uploaded_file): Uploadable
    {
        $this->original_filename = $uploaded_file->getClientOriginalName();
        $this->mime_type = $uploaded_file->getClientMimeType();
        $this->extension = $uploaded_file->getClientOriginalExtension();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDimensions(): Collection
    {
        return collect($this->parent->getImageSizes($this->model_attribute));
    }

    /**
     * {@inheritDoc}
     */
    public function setResizeData(Collection $sizes): Resizable
    {
        $this->sizes = $sizes->merge($this->getDimensions())->toJson();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getWidthHeightRatio(string $size): float
    {
        /*
        this doesn't work for "fit in the box" resizement
        will work for a new project with pre-calculations that
        should be done in ImageProcessService::resize()
        */
        // return json_decode($this->sizes)->{$size}->ratio;

        $physical = $this->getPhysicalImage($size);

        return ($physical->width() / $physical->height());
    }

    /**
     * {@inheritDoc}
     */
    public function getPhysicalImage(?string $size = null)
    {
        if ($this->isFileValid($size)) {
            return \InterventionImage::make($this->getStoragePath($size));
        } else {
            throw new \RuntimeException(sprintf('Problems reading file [%s]. Probably does not exist.', $this->getStoragePath($size)));
        }
    }

    /**
     * Get CRUD controller route.
     *
     * @param string $method
     * @param array $params
     * @return string
     */
    public function getPublicControllerRoute(?string $size = null): string
    {
        return route('image', [ 'image' => $this, 'size' => $size ]);
    }
}
