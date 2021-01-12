<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;

/**
 * Trait to set up images relation to a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
trait HasImages
{
    /**
     * <directory> => [
     *     'width' => <width>
     *     'height' => <height>
     *     'method' => fit|resize|crop
     * ]
     */
    protected $default_image_sizes = [
        'icon' => [
            'width' => 26,
            'height' => 26,
            'method' => 'fit',
            'constraints' => [
                'upsize',
            ],
        ],
        'thumb' => [
            'width' => 64,
            'height' => 64,
            'method' => 'resize',
            'constraints' => [
                'aspectRatio',
                'upsize',
            ],
        ],
        'thumb-square' => [
            'width' => 64,
            'height' => 64,
            'method' => 'fit',
            'constraints' => [
                'upsize',
            ],
        ],
        'small' => [
            'width' => 256,
            'height' => 256,
            'method' => 'resize',
            'constraints' => [
                'aspectRatio',
                'upsize',
            ],
        ],
        'small-square' => [
            'width' => 256,
            'height' => 256,
            'method' => 'fit',
            'constraints' => [
                'upsize',
            ],
        ],
        'mid' => [
            'width' => 512,
            'height' => 512,
            'method' => 'resize',
            'constraints' => [
                'aspectRatio',
                'upsize',
            ],
        ],
    ];

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function images(): MorphMany
    {
        return $this
            ->morphMany(Image::class, 'model')
            ->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'images')
            ->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }

    public function imagePrimary()//: query
    {
        return $this
            ->morphOne(Image::class, 'model')
            ->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'images')
            ->where(sprintf('%s.is_model_primary', (new Image())->getTable()), 1);
    }

    /**
     * Action to take if an image has been uploaded.
     *
     * @param \Softworx\RocXolid\Common\Models\Image $image
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     * @todo events?
     */
    public function onImageUpload(Image $image): Crudable
    {
        return $this;
    }

    /**
     * Retrieve redirect path after the image has been deleted.
     *
     * @return string
     */
    public function deleteImageRedirectPath(): string
    {
        return $this->getControllerRoute('show', [ 'tab' => 'gallery' ]);
    }

    /**
     * Get image dimensions for given attrribute.
     *
     * @param string $attribute
     * @return Illuminate\Support\Collection
     */
    public function getImageSizes(string $attribute): Collection
    {
        if (property_exists($this, 'image_sizes')) {
            if (isset($this->image_sizes[$attribute])) {
                $image_sizes = $this->image_sizes[$attribute];
            } else {
                throw new \InvalidArgumentException(sprintf('Invalid image attribute [%s] requested, [%s] available', $attribute, implode(', ', array_keys($this->image_sizes))));
            }
        } elseif (property_exists($this, 'default_image_sizes')) {
            $image_sizes = $this->default_image_sizes;
        } else {
            throw new \InvalidArgumentException(sprintf('Model [%s] has no image sizes definition', (new \ReflectionClass($this))->getName()));
        }

        return collect($image_sizes);
    }

    // @todo
    public function getImagePlaceholder()
    {
        return config(sprintf('rocXolid.common.placeholder.%s.%s', (new \ReflectionClass($this))->getName(), 'image'), null);
    }
}
