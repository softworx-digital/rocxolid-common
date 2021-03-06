<?php

namespace Softworx\RocXolid\Common\Models\Tables\Attribute;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

/**
 * Default Attribute table.
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
    protected $columns = [
        'image' => [
            'type' => ColumnType\ImageRelation::class,
            'options' => [
                'label' => [
                    'title' => 'image'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
                'size' => 'thumb',
                'relation' => [
                    'name' => 'image',
                ],
                'width' => 64,
            ],
        ],
        'name' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
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
        'background_color' => [
            'type' => ColumnType\Label::class,
            'options' => [
                'label' => [
                    'title' => 'background_color'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'type' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'type'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'units' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'units'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'values' => [
            'type' => ColumnType\Method::class,
            'options' => [
                'label' => [
                    'title' => 'values'
                ],
                'method' => 'formatAttributeValues',
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
        'set-values' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-list',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'set-values',
                ],
                'policy-ability' => 'setValues',
                'action' => 'setValues',
            ],
        ],
        'image' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-image',
                ],
                'attributes' => [
                    'class' => 'btn btn-default btn-sm margin-right-no',
                    'title-key' => 'upload-image',
                ],
                'policy-ability' => 'update',
                'related-action' => [
                    'action' => 'create',
                    'relation' => 'image',
                    'attribute' => 'parent',
                ],/*
                'route-params' => [
                    '_section' => 'asda',
                ],*/
            ],
        ],
        'edit' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'ajax' => true,
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
