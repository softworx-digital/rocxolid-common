<?php

namespace Softworx\RocXolid\Common\Models\Tables\Web;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

class Index extends AbstractCrudTable
{
    protected $columns = [
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
        'description' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'description'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'localizations' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'localizations'
                ],
                'relation' => [
                    'name' => 'localizations',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],/*
        'userGroup' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'user-group'
                ],
                'relation' => [
                    'name' => 'userGroup',
                    'column' => 'name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
        'frontpageSettings' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'frontpage-settings'
                ],
                'relation' => [
                    'name' => 'frontpageSettings',
                    'column' => 'name',
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
