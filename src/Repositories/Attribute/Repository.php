<?php

namespace Softworx\RocXolid\Common\Repositories\Attribute;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// filters
use Softworx\RocXolid\Repositories\Filters\Type\Text as TextFilter,
    Softworx\RocXolid\Repositories\Filters\Type\Select as SelectFilter,
    Softworx\RocXolid\Repositories\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Image;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;
/**
 *
 */
class Repository extends AbstractCrudRepository
{
    protected static $translation_param = 'attribute';

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