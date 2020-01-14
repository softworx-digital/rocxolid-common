<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Locale;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Locale;
use Softworx\RocXolid\Common\Repositories\Locale\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Locale::class;

    protected static $repository_class = Repository::class;
}
