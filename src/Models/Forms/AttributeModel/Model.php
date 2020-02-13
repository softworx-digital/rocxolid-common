<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeModel;

// rocXolid contracts
use Softworx\RocXolid\Forms\Contracts\Form;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;

/**
 *
 */
class Model extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        //'route-action' => 'store', // is set Softworx\RocXolid\Common\Http\Traits\Controllers\Attribute for specific model controller
        'class' => 'form-horizontal form-label-left',
        'section' => 'attributes',
    ];

    protected function getFieldsDefinition(): array
    {
        if (!$this->fields) {
            $this->getModel()->attributeGroups()->each(function ($attribute_group) {
                $attribute_group->attributes->each(function ($attribute) use ($attribute_group) {
                    $this->fields[$attribute->getKey()] = $this->getFormFieldFactory()->makeAttributeFieldDefinition($attribute);
                });
            });
        }

        return $this->adjustFieldsDefinition($this->fields);
    }

    public function buildFields($validate = true): Form
    {
        parent::buildFields($validate);

        $this->setFieldsModelValues();

        return $this;
    }

    public function setFieldsModelValues(): Form
    {
        $this->getModel()->attributeGroups()->each(function ($attribute_group) {
            $attribute_group->attributes->each(function ($attribute) use ($attribute_group) {
                if ($this->hasFormField($attribute->getKey())) {
                    $this
                        ->getFormField($attribute->getKey())
                            ->setValue($this->getModel()->attributeValue($attribute, true))
                            ->updateParent();
                }
            });
        });

        return $this;
    }
}
