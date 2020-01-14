<?php

namespace Softworx\RocXolid\Common\Models\Forms\Web;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete;
use Softworx\RocXolid\Forms\Fields\Type\CollectionTags;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields_order = [
        'name',
        'title',
        'url',
        'domain',
        'email',
        'frontpageSettings',
        'user_group_id',
        'localizations',
        'default_localization_id',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        // $fields['user_group_id']['options']['show-null-option'] = true;
        //
        //$fields['invoice_country_id']['type'] = CollectionSelectAutocomplete::class;
        //$fields['invoice_country_id']['options']['attributes']['data-abs-ajax-url'] = $this->getController()->getRoute('repositoryAutocomplete', $this->getModel(), ['f' => 'invoice_country_id']);

        return $fields;
    }
}
