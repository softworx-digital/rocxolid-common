<?php

namespace Softworx\RocXolid\Common\Models\Forms\Image;

use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type\UploadImageSelf;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
    ];

    protected function adjustFieldsDefinition($fields)
    {
        $fields['image']['type'] = UploadImageSelf::class;
        $fields['image']['options']['multiple'] = false;
        $fields['image']['options']['label']['title'] = 'image';
        // $fields['image']['options']['upload-url'] = $this->getController()->getRoute('imageUpload', $this->getModel());

        return $fields;
    }
}
