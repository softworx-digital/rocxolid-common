<?php

namespace Softworx\RocXolid\Common\Repositories\Web;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;

class Repository extends AbstractCrudRepository
{
    protected $columns = [
        'name' => [
            'type' => Text::class,
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
            'type' => Text::class,
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
            'type' => ModelRelation::class,
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
        'userGroup' => [
            'type' => ModelRelation::class,
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
        'frontpageSettings' => [
            'type' => ModelRelation::class,
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
}