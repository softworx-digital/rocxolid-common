<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
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
                        'unique:webs,domain',
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
        'localizations' => [
            'type' => FieldType\CollectionCheckbox::class,
            'options' => [
                'type-template' => 'collection-checkbox-buttons',
                'collection' => [
                    'model' => Localization::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'localizations',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:localizations,id',
                    ],
                ],
            ],
        ],
        'default_localization_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'label' => [
                    'title' => 'default_localization_id',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:localizations,id',
                    ],
                ],
            ],
        ],
        'is_use_default_localization_url_path' => [
            'type' => FieldType\CheckboxToggle::class,
            'options' => [
                'label' => [
                    'title' => 'is_use_default_localization_url_path',
                ],
            ],
        ],
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $localizations = Localization::findMany($this->getInputFieldValue('localizations'));

        $fields['localizations']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['default_localization_id']['options']['collection'] = $localizations->pluck('name', 'id');

        return $fields;
        // return collect($fields)->only($this->getModel()->getGeneralDataAttributes(true))->toArray();
    }
}
