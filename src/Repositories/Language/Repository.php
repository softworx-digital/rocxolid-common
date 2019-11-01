<?php

namespace Softworx\RocXolid\Common\Repositories\Language;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// filters
use Softworx\RocXolid\Repositories\Filters\Type\Text as TextFilter,
    Softworx\RocXolid\Repositories\Filters\Type\Select as SelectFilter,
    Softworx\RocXolid\Repositories\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Repositories\Columns\Type\Text,
    Softworx\RocXolid\Repositories\Columns\Type\Flag,
    Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;
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
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
        'is_admin_available' => [
            'type' => Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_admin_available'
                ],
            ],
        ],
        'iso_639_1' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'iso_639_1'
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