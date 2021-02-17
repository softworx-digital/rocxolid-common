<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeGroup;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid forms & fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable;

/**
 * AttributeGroup create form.
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
    ];

    /**
     * {@inheritDoc}
     */
    protected $fieldgroups = [
        'base' => [
            'type' => FieldType\FormFieldGroup::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'base',
                    ],
                ],
            ],
        ],
        FieldType\FormFieldGroupAddable::DEFAULT_NAME => [
            'type' => FieldType\FormFieldGroupAddable::class,
            'options' => [
                'wrapper' => [
                    'legend' => [
                        'title' => 'assignments',
                    ],
                ],
            ]
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields = collect($fields)->transform(function (array $definition) {
            $definition['options']['group'] = 'base';
            return $definition;
        })->toArray();

        $fields['model_type']['type'] = FieldType\CollectionSelect::class;
        $fields['model_type']['options']['group'] = FieldType\FormFieldGroupAddable::DEFAULT_NAME;
        $fields['model_type']['options']['array'] = true;
        $fields['model_type']['options']['attributes'] = [
            'col' => 'col-xs-12',
            'class' => 'form-control width-100',
        ];
        $fields['model_type']['options']['placeholder']['title'] = 'select';
        $fields['model_type']['options']['collection'] = $this->getModel()->getAvailableAttributables()->mapWithKeys(function (Attributable $model) {
            return [ $model->className() => $model->getClassNameTranslation() ];
        });
        $fields['model_type']['options']['validation']['rules'][] = 'required';
        $fields['model_type']['options']['validation']['rules'][] = 'class_exists';
        $fields['model_type']['options']['validation']['rules'][] = 'distinct';

        return $fields;
    }
}
