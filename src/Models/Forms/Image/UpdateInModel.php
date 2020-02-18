<?php

namespace Softworx\RocXolid\Common\Models\Forms\Image;

// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class UpdateInModel extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'model',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $attribute = $this->getModel()->model_attribute;

        if ($this->getModel()->parent->$attribute() instanceof MorphOne) {
            unset($fields['is_model_primary']);
            unset($fields['description']);
        }

        return $fields;
    }
}
