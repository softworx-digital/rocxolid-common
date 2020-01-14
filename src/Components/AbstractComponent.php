<?php

namespace Softworx\RocXolid\Common\Components;

use Softworx\RocXolid\Components\AbstractComponent as RocXolidAbstractComponent;

abstract class AbstractComponent extends RocXolidAbstractComponent
{
    protected $view_package = 'rocXolid:common';

    protected $view_directory = '';
}
