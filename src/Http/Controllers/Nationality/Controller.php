<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Nationality;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Nationality;
use Softworx\RocXolid\Common\Repositories\Nationality\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Nationality::class;

    protected static $repository_class = Repository::class;
}