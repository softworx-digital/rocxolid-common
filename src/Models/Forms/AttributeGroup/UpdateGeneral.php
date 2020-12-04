<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeGroup;

// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable;

/**
 * AttributeGroup general data update form.
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
    protected $fields_order = [
        'title',
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields = collect($fields)->only($this->getModel()->getGeneralDataAttributes(true))->toArray();

        $fields['model_type']['type'] = FieldType\CollectionSelect::class;
        // $fields['model_type']['options']['placeholder']['title'] = 'select';
        $fields['model_type']['options']['collection'] = $this->getModel()->getAvailableAttributables()->mapWithKeys(function (Attributable $model) {
            return [ $model->className() => $model->getClassNameTranslation() ];
        });
        $fields['model_type']['options']['validation']['rules'][] = 'required';
        $fields['model_type']['options']['validation']['rules'][] = 'class_exists';

        return $fields;
    }
}
