<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeGroup;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['model_type']['type'] = CollectionSelect::class;
        $fields['model_type']['options']['placeholder']['title'] = 'model_type';
        $fields['model_type']['options']['collection'] = $this->getModel()->getAttributableModels();
        $fields['model_type']['options']['validation']['rules'][] = 'required';
        $fields['model_type']['options']['validation']['rules'][] = 'class_exists';

        return $fields;
    }
}
