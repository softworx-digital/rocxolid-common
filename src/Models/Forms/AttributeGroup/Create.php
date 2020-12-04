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
    protected function adjustFieldsDefinition($fields)
    {
        $fields['model_type']['type'] = FieldType\CollectionSelect::class;
        $fields['model_type']['options']['placeholder']['title'] = 'select';
        $fields['model_type']['options']['collection'] = $this->getModel()->getAvailableAttributables()->mapWithKeys(function (Attributable $model) {
            return [ $model->className() => $model->getClassNameTranslation() ];
        });
        $fields['model_type']['options']['validation']['rules'][] = 'required';
        $fields['model_type']['options']['validation']['rules'][] = 'class_exists';

        return $fields;
    }
}
