<?php

namespace Softworx\RocXolid\Common\Http\Controllers\CadastralArea;

use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Common\Models\CadastralArea;
use Softworx\RocXolid\Common\Repositories\Region\Repository;

class Controller extends AbstractCrudController
{
    protected static $model_class = CadastralArea::class;

    protected static $repository_class = Repository::class;
}
