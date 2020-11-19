<?php

namespace Softworx\RocXolid\Common\Http\Controllers;

// rocXolid controllers
use Softworx\RocXolid\Http\Controllers\AbstractCrudController as RocXolidAbstractCrudController;
// rocXolid admin components
use Softworx\RocXolid\Admin\Components\Dashboard\Crud as CrudDashboard;

/**
 * rocXolid Common CRUD controller.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
abstract class AbstractCrudController extends RocXolidAbstractCrudController
{
    protected static $dashboard_type = CrudDashboard::class;

    protected $translation_package = 'rocXolid:common';
}
