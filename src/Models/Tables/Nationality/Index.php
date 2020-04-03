<?php

namespace Softworx\RocXolid\Common\Models\Tables\Nationality;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Columns\Type\Text;

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
    ];
}
