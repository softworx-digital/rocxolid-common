<?php

namespace Softworx\RocXolid\Common\Models\Forms\AttributeModel;

// rocXolid forms
use Softworx\RocXolid\Forms\Builders\Contracts\FormFieldFactory;
use Softworx\RocXolid\Forms\Contracts\Form;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid common forms
use Softworx\RocXolid\Common\Models\Forms\Attribute\Support\FormFieldFactory as AttributeFormFieldFactory;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 *
 */
class General extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        //'route-action' => 'store', // is set Softworx\RocXolid\Common\Http\Traits\Controllers\Attribute for specific model controller
        'class' => 'form-horizontal form-label-left',
        'section' => 'attributes',
    ];

    /**
     * {@inheritDoc}
     */
    protected function getFieldsDefinition(): array
    {
        if (!$this->fields) {
            $this->getController()->getAttributeGroup()->attributes->each(function (Attribute $attribute) {
                $this->fields[$attribute->getKey()] = $this->getFormFieldFactory()->makeAttributeFieldDefinition($attribute);
            });
        }

        return $this->adjustFieldsDefinition($this->fields) ?: [];
    }

    /**
     * {@inheritDoc}
     */
    public function buildFields($validate = true): Form
    {
        parent::buildFields($validate);

        $this->setFieldsModelValues();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     * @todo hotfixed, unoptimized, make general forms refactoring forst to fix it properly
     */
    public function getFormFieldFactory(): FormFieldFactory
    {
        return app(AttributeFormFieldFactory::class);
    }
}
