<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Localization;

/**
 * Web localization data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateLocalization extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'localization-data',
    ];

    protected $fields = [
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
        $localizations = !is_null($this->getInputFieldValue('localizations')) ? Localization::findMany($this->getInputFieldValue('localizations')) : $this->getModel()->localizations;

        $fields['localizations']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['default_localization_id']['options']['collection'] = $localizations->pluck('name', 'id');

        return $fields;
        // return collect($fields)->only($this->getModel()->getLocalizationDataAttributes(true))->toArray();
    }
}
