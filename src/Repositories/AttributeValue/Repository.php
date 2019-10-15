<?php

namespace Softworx\RocXolid\Common\Repositories\AttributeValue;

use Softworx\RocXolid\Repositories\AbstractCrudRepository;
/**
 *
 */
class Repository extends AbstractCrudRepository
{
    protected static $translation_param = 'attribute-value';

    protected $filters = [];

    protected $columns = [];
}