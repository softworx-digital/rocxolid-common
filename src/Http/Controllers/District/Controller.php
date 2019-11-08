<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Region;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Repositories\Region\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Region::class;

    protected static $repository_class = Repository::class;
}