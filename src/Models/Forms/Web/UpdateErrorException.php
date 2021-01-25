<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms & fields
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Web "exception" error data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateErrorException extends RocXolidAbstractCrudForm
{
    /**
     * {@inheritDoc}
     */
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'error-exception-data',
    ];

    /**
     * {@inheritDoc}
     */
    // protected $fields_order = [];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition($fields)
    {
        $fields = collect($fields)->only($this->getModel()->getErrorExceptionDataAttributes(true))->toArray();

        $fields['error_exception_message']['type'] = FieldType\WysiwygTextarea::class;

        return $fields;
    }
}
