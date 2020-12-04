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
        'full_name' => [
            'type' => FilterType\Text::class,
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

    /**
     * {@inheritDoc}
     */
    protected $columns = [
        'name' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
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
        ],
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
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected $buttons = [
        'show' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'label' => [
                    'icon' => 'fa fa-window-maximize',
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
