<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Web model label data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateLabelData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    // protected $fields_order = [];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.label'))->toArray();

        return $fields;
    }
}
