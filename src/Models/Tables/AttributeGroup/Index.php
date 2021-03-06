<?php

namespace Softworx\RocXolid\Common\Models\Tables\AttributeGroup;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

/**
 * Default AttributeGroup table.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Index extends AbstractCrudTable
{
    /**
     * {@inheritDoc}
     */
    protected $filters = [
        'name' => [
            'type' => FilterType\Text::class,
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

    /**
     * {@inheritDoc}
     */
    protected $columns = [
        'is_filterable' => [
            'type' => ColumnType\Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_filterable',
                ],
            ],
        ],
        'name' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
        'code' => [
            'type' => ColumnType\Text::class,
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
        'model_type' => [
            'type' => ColumnType\Method::class,
            'options' => [
                'label' => [
                    'title' => 'model_type'
                ],
                'method' => 'getModelTypeTitle',
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'note' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'note'
                ],
            ],
        ],/*
        'attributes' => [
            'type' => ColumnType\ModelRelation::class,
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
        ],*/
    ];

    /**
     * {@inheritDoc}
     */
    protected $buttons = [
        'show' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-eye',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'show',
                ],
                'policy-ability' => 'view',
                'action' => 'show',
            ],
        ],
        'delete-ajax' => [
            'type' => ButtonType\ButtonAnchor::class,
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
