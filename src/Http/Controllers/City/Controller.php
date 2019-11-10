<?php

namespace Softworx\RocXolid\Common\Http\Controllers\City;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\City;
use Softworx\RocXolid\Common\Repositories\Region\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = City::class;

    protected static $repository_class = Repository::class;
}