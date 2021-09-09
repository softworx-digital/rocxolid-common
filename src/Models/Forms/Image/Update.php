<?php

namespace Softworx\RocXolid\Common\Models\Forms\Image;

// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $system_fields = [
        'relation' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_attribute' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_type' => [
            'type' => Hidden::class,
            'options' => [],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields = $this->system_fields + $fields;

        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');
        $fields['model_type']['options']['value'] = $this->getInputFieldValue('model_type');

        $attribute = $this->getModel()->model_attribute;

        if ($this->getModel()->parent->$attribute() instanceof MorphOne) {
            unset($fields['is_model_primary']);
            // unset($fields['description']);
        }

        return $fields;
    }
}
