<?php

namespace Softworx\RocXolid\Common\Http\Controllers;

use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
// admin components
use Softworx\RocXolid\Admin\Components\Dashboard\Crud as CrudDashboard;

abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    protected static $dashboard_type = CrudDashboard::class;

    protected $translation_package = 'rocXolid:common';
}
