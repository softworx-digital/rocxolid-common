<?php

namespace Softworx\RocXolid\Common\Components\ModelViewers;

// rocXolid components
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer as RocXolidCrudModelViewer;

/**
 * Base component to be used for viewing CRUDable models for common package.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
abstract class AbstractCrudModelViewer extends RocXolidCrudModelViewer
{
    /**
     * @inheritDoc
     */
    protected $view_package = 'rocXolid:common';
}
