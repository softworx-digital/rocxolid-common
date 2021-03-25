<?php

namespace Softworx\RocXolid\Common\Models\Tables\Locale;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Tables\Columns\Type\Text;
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
