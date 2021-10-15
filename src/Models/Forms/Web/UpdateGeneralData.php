<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;

/**
 * Web model general data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateGeneralData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.general'))->toArray();
        //
        $fields['url']['options']['validation']['rules'] = [
            'required',
            'url',
        ];
        //
        $fields['domain']['options']['validation']['rules'] = [
            'required',
            'regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i',
            'max:255',
        ];
        //
        $fields['email']['options']['validation']['rules'] = [
            'required',
            'email',
        ];

        return $fields;
    }
}
