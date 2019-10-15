<?php

namespace Softworx\RocXolid\Common\Components\Forms\Attribute;

use Softworx\RocXolid\Components\Forms\CrudForm as RocXolidCrudForm;
/**
 *
 */
class CrudForm extends RocXolidCrudForm
{
    protected static $field_component_class = FormField::class; // attribute form field component
}