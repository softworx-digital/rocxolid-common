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
