<?php

namespace Softworx\RocXolid\Common\Models\Tables\Attribute;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\Image;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $filters = [
        'full_name' => [
            'type' => TextFilter::class,
            'options' => [
                'label' => [
                    'title' => 'full_name'
                ],
                'attributes' => [
                    'placeholder' => 'name'
                ],
            ],
        ],
    ];

    protected $columns = [
        'flag' => [
            'type' => Image::class,
            'options' => [
                'label' => [
                    'title' => 'flag',
                ],
                'path' => '/images/flags',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'full_name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
        'iso_3166_2' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'code'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'capital' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'capital'
                ],
            ],
        ],
        'currency_code' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'currency_code'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'currency_symbol' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'currency_symbol'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'currency_iso_4217' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'currency_iso_4217'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];
}
