<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Image;

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
        'images' => [
            'thumb' => [
                'width' => 64,
                'height' => 64,
                'method' => 'resize',
                'constraints' => [
                    'aspectRatio',
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
            '600x600' => [
                'width' => 600,
                'height' => 600,
                'method' => 'fit',
                'constraints' => [
                    'upsize',
                ],
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
}
