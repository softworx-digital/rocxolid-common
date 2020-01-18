<?php

namespace Softworx\RocXolid\Common\Models\Forms\Image;

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

        if (!($this->getModel()->parent->$attribute instanceof Collection)) {
            unset($fields['is_model_primary']);
        }

        return $fields;
    }
}
