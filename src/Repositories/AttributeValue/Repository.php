<?php

namespace Softworx\RocXolid\Common\Repositories\AttributeValue;

// rocXolid repositories
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Repositories\CrudRepository;
// rocXolid user management models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * AttributeValue repository.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Repository extends CrudRepository
{
    /**
     * @var \Softworx\RocXolid\Common\Models\Attribute
     */
    protected $attribute;

    /**
     * Attribute reference setter.
     *
     * @param \Softworx\RocXolid\Common\Models\Attribute $attribute
     * @return self
     */
    public function setAttribute(Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function initQueryModel(): RepositoryContract
    {
        if (filled($this->attribute)) {
            $this->query_model::bootAssociatedAttribute($this->attribute);
        }

        return $this;
    }
}
