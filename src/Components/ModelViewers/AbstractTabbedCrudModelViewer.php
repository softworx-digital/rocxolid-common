<?php

namespace Softworx\RocXolid\Common\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\TabbedCrudModelViewer as RocXolidTabbedCrudModelViewer;

/**
 * Model viewer component with integrated tab support for common package.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
abstract class AbstractTabbedCrudModelViewer extends RocXolidTabbedCrudModelViewer
{
    /**
     * @inheritDoc
     */
    protected $view_package = 'rocXolid:common';
}
