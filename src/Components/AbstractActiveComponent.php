<?php

namespace Softworx\RocXolid\Common\Components;

use Softworx\RocXolid\Components\AbstractActiveComponent as RocXolidAbstractActiveComponent;

abstract class AbstractActiveComponent extends RocXolidAbstractActiveComponent
{
    protected $view_package = 'rocXolid:common';

    protected $view_directory = '';
}