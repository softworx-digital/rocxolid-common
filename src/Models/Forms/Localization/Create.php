<?php

namespace Softworx\RocXolid\Common\Models\Forms\Localization;

use Illuminate\Validation\Rule;
// base form
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// fields
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete;

/**
 *
 */
class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['seo_url_slug']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'seo_url_slug');
        //
        //$fields['country_id']['type'] = CollectionSelectAutocomplete::class; // blbne autocomplete
        //$fields['country_id']['options']['attributes']['data-abs-ajax-url'] = $this->getController()->getRoute('repositoryAutocomplete', $this->getModel(), ['f' => 'country_id']);
        $fields['country_id']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'country_id')->where(function ($query) {
            $query
                ->where('language_id', $this->getFormField('language_id')->getValue())
                ->where('locale_id', $this->getFormField('locale_id')->getValue());
        });
        //
        //$fields['language_id']['type'] = CollectionSelectAutocomplete::class;
        //$fields['language_id']['options']['attributes']['data-abs-ajax-url'] = $this->getController()->getRoute('repositoryAutocomplete', $this->getModel(), ['f' => 'language_id']);
        $fields['language_id']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'language_id')->where(function ($query) {
            $query
                ->where('country_id', $this->getFormField('country_id')->getValue())
                ->where('locale_id', $this->getFormField('locale_id')->getValue());
        });
        //
        //$fields['locale_id']['type'] = CollectionSelectAutocomplete::class;
        //$fields['locale_id']['options']['attributes']['data-abs-ajax-url'] = $this->getController()->getRoute('repositoryAutocomplete', $this->getModel(), ['f' => 'locale_id']);
        $fields['locale_id']['options']['validation']['rules'][] = Rule::unique($this->getModel()->getTable(), 'locale_id')->where(function ($query) {
            $query
                ->where('country_id', $this->getFormField('country_id')->getValue())
                ->where('language_id', $this->getFormField('language_id')->getValue());
        });

        return $fields;
    }
}
