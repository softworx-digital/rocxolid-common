<?php

namespace Softworx\RocXolid\Common\Repositories\Locale;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// filters
use Softworx\RocXolid\Repositories\Filters\Type\Text as TextFilter,
    Softworx\RocXolid\Repositories\Filters\Type\Select as SelectFilter,
    Softworx\RocXolid\Repositories\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
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
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
        'local_name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'local_name'
                ],
            ],
        ],
        'code' => [
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
    ];
}