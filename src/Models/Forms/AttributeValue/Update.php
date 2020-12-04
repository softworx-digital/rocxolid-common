<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeValue;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid forms & fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * AttributeValue update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Update extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'attribute-values',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [/*
        'relation' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_attribute' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],*/
        'name' => [
            'type' => FieldType\Input::class,
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
            'type' => FieldType\Textarea::class,
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
            'type' => FieldType\Textarea::class,
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

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        // $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        // $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');

        return $fields;
    }
}
