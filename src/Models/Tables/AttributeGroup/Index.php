<?php

namespace Softworx\RocXolid\Common\Models\Tables\AttributeGroup;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
// columns
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\Image;
use Softworx\RocXolid\Tables\Columns\Type\Method;
use Softworx\RocXolid\Tables\Columns\Type\ButtonAnchor;
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
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
        'model_type' => [
            'type' => Method::class,
            'options' => [
                'label' => [
                    'title' => 'model_type'
                ],
                'method' => 'getModelType',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'description' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'description'
                ],
            ],
        ],
        'note' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'note'
                ],
            ],
        ],
        'attributes' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'attributes'
                ],
                'relation' => [
                    'name' => 'attributes',
                    'column' => 'name',
                    'max-count' => 15
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];

    protected $buttons = [
        'attributes' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-list',
                ],
                'attributes' => [
                    'class' => 'btn btn-success btn-sm margin-right-no',
                    'title-key' => 'attributes',
                ],
                'policy-ability' => 'view',
                'action' => 'show',
            ],
        ],
        'edit' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-pencil',
                ],
                'attributes' => [
                    'class' => 'btn btn-primary btn-sm margin-right-no',
                    'title-key' => 'edit',
                ],
                'policy-ability' => 'update',
                'action' => 'edit',
            ],
        ],
        'delete-ajax' => [
            'type' => ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-trash',
                ],
                'attributes' => [
                    'class' => 'btn btn-danger btn-sm margin-right-no',
                    'title-key' => 'delete',
                ],
                'policy-ability' => 'delete',
                'action' => 'destroyConfirm',
            ],
        ],
    ];
}
