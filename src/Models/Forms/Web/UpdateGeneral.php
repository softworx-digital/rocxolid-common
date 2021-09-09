<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

use Illuminate\Validation\Rule;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Web general data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateGeneral extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'general-data',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fields = [
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
        'title' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'title',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'url' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'url',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'url',
                        'max:255',
                    ],
                ],
            ],
        ],
        'domain' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'domain',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i',
                        'max:255',
                    ],
                ],
            ],
        ],
        'email' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'email',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'email',
                        'max:255',
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
        $fields['domain']['options']['validation']['rules'][] = Rule::unique('webs', 'domain')->ignore($this->getModel()->getKey());
        // return collect($fields)->only($this->getModel()->getGeneralDataAttributes(true))->toArray();
        return $fields;
    }
}
