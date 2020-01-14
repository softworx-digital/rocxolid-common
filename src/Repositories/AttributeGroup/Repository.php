<?php

namespace Softworx\RocXolid\Common\Repositories\AttributeGroup;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// filters
use Softworx\RocXolid\Repositories\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Repositories\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Repositories\Filters\Type\ModelRelation as ModelRelationFilter;
// columns
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\Image;
use Softworx\RocXolid\Repositories\Columns\Type\Method;
use Softworx\RocXolid\Repositories\Columns\Type\ButtonAnchor;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;

/**
 *
 */
class Repository extends AbstractCrudRepository
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
                'controller-method' => 'show',
                'permissions-method-group' => 'write',
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
                'controller-method' => 'edit',
                'permissions-method-group' => 'write',
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
                'controller-method' => 'destroyConfirm',
                'permissions-method-group' => 'write',
            ],
        ],
    ];
}
