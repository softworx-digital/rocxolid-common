<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Web model "exception" error data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateErrorExceptionData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.error-exception'))->toArray();

        $fields['error_exception_message']['type'] = FieldType\WysiwygTextarea::class;

        return $fields;
    }
}
