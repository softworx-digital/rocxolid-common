<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\Image;

trait HasImage
{
    /**
     * <directory> => [
     *     'width' => <width>
     *     'height' => <height>
     *     'method' => fit|resize|crop
     * ]
     */
    protected $default_image_dimensions = [
        'image' => [
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
            'small' => [
                'width' => 256,
                'height' => 256,
                'method' => 'resize',
                'constraints' => [
                    'aspectRatio',
                    'upsize',
                ],
            ],
        ],
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', (new Image())->getTable()), 'image')->orderBy(sprintf('%s.model_attribute_position', (new Image())->getTable()));
    }
}