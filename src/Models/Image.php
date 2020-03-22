<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Collection;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Resizable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\File;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

/**
 *
 */
class Image extends File implements Resizable
{
    protected $fillable = [
        'is_model_primary',
        //'name',
        'alt',
        'description',
    ];

    protected $relationships = [
    ];

    public function parent()
    {
        return $this->morphTo('model');
    }

    public function resolvePolymorphUserModel()
    {
        return User::class;
    }

    public function fillCustom($data, $action = null)
    {
        if (is_null($this->model_attribute)) {
            $this->model_attribute = $data['model_attribute'];
        }

        return parent::fillCustom($data, $action);
    }

    public function getMimeType()
    {
        return mime_content_type($this->getStoragePath());
    }

    public function base64($size = 'icon')
    {
        try {
            return sprintf('data:%s;base64,%s', $this->getMimeType(), base64_encode($this->content($size)));
        } catch (\Exception $e) {
            return config('rocXolid.common.general.base64-image-preloader');
        }
    }

    public function getHeightWidthRatio($size): float
    {
        try {
            $intervention_image = \InterventionImage::make($this->getStoragePath($size));

            return $intervention_image->height() / $intervention_image->width();
        } catch (\Exception $e) {
            return 1;
        }
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
}
