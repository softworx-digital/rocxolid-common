<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudUpdateForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Localization;

/**
 * Web model localization data update form.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class UpdateLocalizationData extends AbstractCrudUpdateForm
{
    /**
     * {@inheritDoc}
     */
    protected $fields_order = [
        'localizations',
        'default_localization_id',
        'is_use_default_localization_url_path',
    ];

    /**
     * {@inheritDoc}
     */
    protected function adjustFieldsDefinition(array $fields): array
    {
        $localizations = !is_null($this->getInputFieldValue('localizations')) ? Localization::findMany($this->getInputFieldValue('localizations')) : $this->getModel()->localizations;

        $fields = collect($fields)->only($this->getModel()->getModelViewerComponent()->panelData('data.localization'))->toArray();

        $fields['localizations']['options']['type-template'] = 'collection-checkbox-buttons';
        $fields['localizations']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $fields['default_localization_id']['options']['collection'] = $localizations->pluck('name', 'id');
        $fields['default_localization_id']['options']['validation']['rules'] = [
            'required',
            'exists:localizations,id',
        ];

        return $fields;
    }
}
