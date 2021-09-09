<?php

namespace Softworx\RocXolid\Common\Models\Tables\Web;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

class Index extends AbstractCrudTable
{
    protected $columns = [
        'is_enabled' => [
            'type' => ColumnType\SwitchFlag::class,
            'options' => [
                'label' => [
                    'title' => 'is_enabled'
                ],
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
        'title' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'title'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'url' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'url'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'domain' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'domain'
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
        ],
        'default_localization_id' => [
            'type' => ColumnType\ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'default_localization_id'
                ],
                'relation' => [
                    'name' => 'defaultLocalization',
                    'column' => 'title',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'is_use_default_localization_url_path' => [
            'type' => ColumnType\Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_use_default_localization_url_path'
                ],
            ],
        ],
        'is_error_exception_debug_mode' => [
            'type' => ColumnType\Flag::class,
            'options' => [
                'label' => [
                    'title' => 'is_error_exception_debug_mode'
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
