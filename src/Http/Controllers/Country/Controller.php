<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Country;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Country;
use Softworx\RocXolid\Common\Repositories\Country\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Country::class;

    protected static $repository_class = Repository::class;
}
