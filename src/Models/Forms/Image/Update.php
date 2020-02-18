<?php

namespace Softworx\RocXolid\Common\Models\Forms\Image;

// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];
}
