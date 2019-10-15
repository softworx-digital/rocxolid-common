<?php

namespace Softworx\RocXolid\Common\Components\Forms\Attribute;

use Softworx\RocXolid\Components\Forms\FormField as RocXolidFormField;

class FormField extends RocXolidFormField
{
    public function translate($key, $use_repository_param = true)
    {
        return $key;
    }
}