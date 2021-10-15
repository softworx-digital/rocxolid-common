<?php

namespace Softworx\RocXolid\Common\Models\Forms\WebFrontpageSettings;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// use Softworx\RocXolid\Common\Facades\ThemeManager;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        // $fields['theme']['type'] = FieldType\Select::class;
        // $fields['theme']['options']['choices'] = ThemeManager::getThemes();

        return $fields;
    }
}
