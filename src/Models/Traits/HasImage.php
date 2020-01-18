<?php

namespace Softworx\RocXolid\Common\Models\Traits;

// rocXolid utils
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
// rocXolid common models
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
    protected $default_image_sizes = [
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
        ],
    ];

    public function image()
    {
        $table = (new Image())->getTable();

        return $this->morphOne(Image::class, 'model')->where(sprintf('%s.model_attribute', $table), 'image')->orderBy(sprintf('%s.model_attribute_position', $table));
    }

    public function onImageUpload(Image $image, AjaxResponse &$response)
    {
        return $this;
    }

    public function deleteImageRedirectPath()
    {
        return $this->getControllerRoute('show');
    }
}
