<?php

namespace Softworx\RocXolid\Common\Models\Forms\Attribute;

// @todo - upratat
use Illuminate\Support\Collection;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Textarea;
use Softworx\RocXolid\Forms\Fields\Type\Switchery;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class CreateInAttributeGroup extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'attributes',
    ];

    protected $fields = [
        'attribute_group_id' => [
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
        'type' => [
            'type' => Select::class,
            'options' => [
                // 'choices' => ...adjusted
                'label' => [
                    'title' => 'type',
                ],
                'attributes' => [

                ],
            ],
        ],/*
        'is_multiple' => [
            'type' => Switchery::class,
            'options' => [
                'label' => [
                    'title' => 'is_multiple',
                ],
                'value' => 0,
                'validation' => [
                    'rules' => [
                        'in:0,1'
                    ],
                ],
            ],
        ],*/
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
                    'title' => 'submit_ajax',
                ],
                'attributes' => [
                    'class' => 'btn btn-success',
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields = array_merge_recursive($fields, [
            'type' => [
                'options' => [
                    'choices' => [
                        'boolean' => __('rocXolid::attribute.type-choices.boolean'),
                        'integer' => __('rocXolid::attribute.type-choices.integer'),
                        'decimal' => __('rocXolid::attribute.type-choices.decimal'),
                        'string' => __('rocXolid::attribute.type-choices.string'),
                        'text' => __('rocXolid::attribute.type-choices.text'),
                        'enum' => __('rocXolid::attribute.type-choices.enum'),
                    ],
                    /*
                    'attributes' => [
                        'data-change-action' => $this->getController()->getRoute('loadProductData', $this->getModel()),
                    ],
                    */
                ],
            ],
        ]);

        return $fields;
    }
}