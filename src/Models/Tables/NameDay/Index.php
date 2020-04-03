<?php

namespace Softworx\RocXolid\Common\Models\Tables\NameDay;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\Method;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $filters = [
        'name' => [
            'type' => TextFilter::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
                'attributes' => [
                    'placeholder' => 'name'
                ],
            ],
        ],
    ];

    protected $columns = [
        'country' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'country'
                ],
                'relation' => [
                    'name' => 'country',
                    'column' => 'full_name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],/*
        'day' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'day'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
        'date' => [
            'type' => Method::class,
            'options' => [
                'label' => [
                    'title' => 'date'
                ],
                'method' => 'getDate',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
    ];
}
