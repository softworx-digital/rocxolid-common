<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Language;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Repositories\Language\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = Language::class;

    protected static $repository_class = Repository::class;
}
