<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;

/**
 * Trait to set up image relation to a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
trait HasImage
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
    public function image(): MorphOne
    {
        $table = (new Image())->getTable();

        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', $table), 'image')->orderBy(sprintf('%s.model_attribute_position', $table));
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
        return $this->getControllerRoute('show');
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

    /*
    public function getImageSize(string $attribute, $size)
    {
        $image_sizes = $this->getImageDimensions($attribute);

        if (!isset($image_sizes[$size])) {
            throw new \InvalidArgumentException(sprintf('Invalid size [%s] for attribute [%s] requested, [%s] available', $size, $attribute, implode(', ', array_keys($image_sizes))));
        }

        return (object)$image_sizes[$size];
    }
    */
}
