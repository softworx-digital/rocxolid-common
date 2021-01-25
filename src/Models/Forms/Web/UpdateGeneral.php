<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Web general data update form.
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
    /*
    protected $fields_order = [
        'name',
        'title',
        'url',
        'domain',
        'email',
        'warehouse_id',
        'user_group_id',
        'country_id',
        'language_id',
        'locale_id',
    ];
    */

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        return collect($fields)->only($this->getModel()->getGeneralDataAttributes(true))->toArray();
    }
}
