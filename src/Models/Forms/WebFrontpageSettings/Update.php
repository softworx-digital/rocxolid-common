<?php

namespace Softworx\RocXolid\Common\Models\Forms\WebFrontpageSettings;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
use Softworx\RocXolid\CMS\Facades\ThemeManager;

/**
 *
 */
class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        // $fields['theme']['type'] = FieldType\Select::class;
        // $fields['theme']['options']['choices'] = ThemeManager::getThemes();

        /*
        $fields['logo']['type'] = UploadImage::class;
        $fields['logo']['options']['multiple'] = false;
        $fields['logo']['options']['label']['title'] = 'logo';

        $fields['logoInverted']['type'] = UploadImage::class;
        $fields['logoInverted']['options']['multiple'] = false;
        $fields['logoInverted']['options']['label']['title'] = 'logo-mobile';

        $fields['favicon']['type'] = UploadImage::class;
        $fields['favicon']['options']['multiple'] = false;
        $fields['favicon']['options']['label']['title'] = 'favicon';
        $fields['favicon']['options']['image-preview-size'] = '144x144';

        $fields['cssFiles']['type'] = UploadFile::class;
        $fields['cssFiles']['options']['multiple'] = true;
        $fields['cssFiles']['options']['label']['title'] = 'cssFiles';

        $fields['jsFiles']['type'] = UploadFile::class;
        $fields['jsFiles']['options']['multiple'] = true;
        $fields['jsFiles']['options']['label']['title'] = 'jsFiles';
        */

        unset($fields['web_id']);
        unset($fields['name']);

        return $fields;
    }
}
