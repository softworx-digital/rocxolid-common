<?php

namespace Softworx\RocXolid\Common\Http\Controllers\District;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\District;
use Softworx\RocXolid\Common\Repositories\Region\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = District::class;

    protected static $repository_class = Repository::class;
}
