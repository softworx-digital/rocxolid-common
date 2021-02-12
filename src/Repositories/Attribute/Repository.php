<?php

namespace Softworx\RocXolid\Common\Repositories\Attribute;

// rocXolid repositories
use Softworx\RocXolid\Repositories\Contracts\Repository as RepositoryContract;
use Softworx\RocXolid\Repositories\CrudRepository;
// rocXolid user management models
use Softworx\RocXolid\Common\Models\AttributeGroup;

/**
 * Attribute repository.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Repository extends CrudRepository
{
    /**
     * @var \Softworx\RocXolid\Common\Models\AttributeGroup
     */
    protected $attribute_group;

    /**
     * AttributeGroup reference setter.
     *
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group
     * @return self
     */
    public function setAttributeGroup(AttributeGroup $attribute_group): self
    {
        $this->attribute_group = $attribute_group;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function initQueryModel(): RepositoryContract
    {
        if (filled($this->attribute_group)) {
            $this->query_model::bootAssociatedAttributeGroup($this->attribute_group);
        }

        return $this;
    }
}
