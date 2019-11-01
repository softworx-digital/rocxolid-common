<?php

namespace Softworx\RocXolid\Common\Repositories\NameDay;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// filters
use Softworx\RocXolid\Repositories\Filters\Type\Text as TextFilter,
    Softworx\RocXolid\Repositories\Filters\Type\Select as SelectFilter,
    Softworx\RocXolid\Repositories\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Method;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;
/**
 *
 */
class Repository extends AbstractCrudRepository
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