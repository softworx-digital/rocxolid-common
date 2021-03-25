<?php

namespace Softworx\RocXolid\Common\Models\Tables\CommandLog;

// rocXolid tables & types
use Softworx\RocXolid\Tables\AbstractCrudTable;
use Softworx\RocXolid\Tables\Filters\Type as FilterType;
use Softworx\RocXolid\Tables\Columns\Type as ColumnType;
use Softworx\RocXolid\Tables\Buttons\Type as ButtonType;

/**
 * Default CommandLog table.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Index extends AbstractCrudTable
{
    protected $columns = [/*
        'caller' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'caller'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],*/
        'command' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'command'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'started_at' => [
            'type' => ColumnType\DateTime::class,
            'options' => [
                'isoFormat' => 'll LTS',
                'orderable' => true,
                'label' => [
                    'title' => 'started_at'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'finished_at' => [
            'type' => ColumnType\DateTime::class,
            'options' => [
                'isoFormat' => 'll LTS',
                'orderable' => true,
                'label' => [
                    'title' => 'finished_at'
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'state' => [
            'type' => ColumnType\Text::class,
            'options' => [
                'label' => [
                    'title' => 'state'
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
        'show-modal' => [
            'type' => ButtonType\ButtonAnchor::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'icon' => 'fa fa-window-restore',
                ],
                'attributes' => [
                    'class' => 'btn btn-info btn-sm margin-right-no',
                    'title-key' => 'show-modal',
                ],
                'policy-ability' => 'view',
                'action' => 'show',
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function getDefaultOrderByColumn(): string
    {
        return 'started_at';
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultOrderByDirection(): string
    {
        return 'desc';
    }
}
