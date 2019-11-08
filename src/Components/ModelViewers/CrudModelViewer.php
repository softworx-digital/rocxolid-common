<?php

namespace Softworx\RocXolid\Common\Components\ModelViewers;

use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 *
 */
class CrudModelViewer extends RocXolidCrudModelViewer
{
    protected $view_package = 'rocXolid:common';

    protected $view_directory = '';

    protected $translation_package = 'rocXolid:common';
}
