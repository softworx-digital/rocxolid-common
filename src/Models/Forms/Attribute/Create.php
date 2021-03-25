<?php

namespace Softworx\RocXolid\Common\Models\Forms\Attribute;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid forms & fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * Attribute create form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Create extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
        'section' => 'attributes',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
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
        ],
        'attribute_group_id' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:attribute_groups,id',
                    ],
                ],
            ],
        ],
        'type' => [
            'type' => FieldType\CollectionRadioList::class,
            'options' => [
                'label' => [
                    'title' => 'type',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],/*
        'is_multiple' => [
            'type' => FieldType\CheckboxToggle::class,
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
        'code' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'code',
                ],
                'validation' => [
                    'rules' => [
                        'max:255',
                    ],
                ],
            ],
        ],
        'background_color' => [
            'type' => FieldType\Colorpicker::class,
            'options' => [
                'label' => [
                    'title' => 'background_color',
                ],
            ],
        ],
        'units' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'units',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
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
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');
        $fields['attribute_group_id']['options']['value'] = $this->getInputFieldValue('attribute_group_id');
        //
        $fields['type']['options']['collection'] = collect(Attribute::TYPES)->mapWithKeys(function (string $type) {
            return [ $type => $this->getModel()->getModelViewerComponent()->translate(sprintf('choice.type.%s', $type)) ];
        });
        $fields['type']['options']['validation']['rules'][] = sprintf('in:%s', collect(Attribute::TYPES)->join(','));
        $fields['type']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());

        if (!collect([ 'integer', 'decimal', 'string', ])->contains($this->getInputFieldValue('type'))) {
            unset($fields['units']);
        }

        return $fields;
    }
}
