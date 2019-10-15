<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Localization;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Localization;
use Softworx\RocXolid\Common\Repositories\Localization\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Localization::class;

    protected static $repository_class = Repository::class;
}