<?php

namespace Softworx\RocXolid\Common\Http\Controllers\NameDay;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\NameDay;
use Softworx\RocXolid\Common\Repositories\NameDay\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = NameDay::class;

    protected static $repository_class = Repository::class;
}