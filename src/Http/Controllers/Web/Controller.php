<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Web;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Repositories\Web\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Web::class;

    protected static $repository_class = Repository::class;
}
