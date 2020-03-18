<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeValue;

// @todo - upratat
use Illuminate\Support\Collection;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Textarea;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class CreateInAttribute extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'attribute-values',
    ];

    protected $fields = [
        'attribute_id' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        //'exists:attribute_groups',
                    ],
                ],
            ],
        ],
        'name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'description' => [
            'type' => Textarea::class,
            'options' => [
                'label' => [
                    'title' => 'description',
                ],
                'validation' => [
                    'rules' => [
                        'max:512',
                    ],
                ],
            ],
        ],
        'note' => [
            'type' => Textarea::class,
            'options' => [
                'label' => [
                    'title' => 'note',
                ],
                'validation' => [
                    'rules' => [
                        'max:512',
                    ],
                ],
            ],
        ],
    ];

    protected $buttons = [
        // submit - default group
        'submit-ajax' => [
            'type' => ButtonSubmit::class,
            'options' => [
                'group' => ButtonGroup::DEFAULT_NAME,
                'ajax' => true,
                'label' => [
                    'title' => 'submit',
                ],
                'attributes' => [
                    'class' => 'btn btn-success',
                ],
            ],
        ],
    ];
}
