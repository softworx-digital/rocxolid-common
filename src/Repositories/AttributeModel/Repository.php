<?php

namespace Softworx\RocXolid\Common\Repositories\AttributeModel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
// rocXolid repositories
use Softworx\RocXolid\Repositories\CrudRepository;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;
use Softworx\RocXolid\Common\Models\AttributeGroup;

/**
 * AttributeModel repository.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo: revise & better use pivots instead probably
 */
class Repository extends CrudRepository
{
    /**
     * @var \Softworx\RocXolid\Common\Models\AttributeGroup Reference to requested AttributeGroup.
     */
    private $attribute_group;

    /**
     * {@inheritDoc}
     */
    public function updateModel(Crudable $model, Collection $data): Crudable
    {
        // $model->attributeGroupValues($this->getAttributeGroup())->detach();
        DB::table($model->attributeValues()->getTable())
            ->join(
                $model->attributeValues()->getRelated()->getTable(),
                $model->attributeValues()->getQualifiedRelatedPivotKeyName(),
                '=',
                $model->attributeValues()->getRelated()->getQualifiedKeyName()
            )
            ->where($model->attributeValues()->getQualifiedForeignPivotKeyName(), $model->getKey())
            ->where($model->attributeValues()->getMorphType(), $model->className())
            ->where($model->attributeValues()->getRelated()->attributeGroup()->getQualifiedForeignKeyName(), $this->getAttributeGroup()->getKey())
            ->delete();

        $data->each(function ($value, int $attribute_id) use ($model) {
            $attribute = Attribute::findOrFail($attribute_id);

            // $model->attributeGroupValues($this->getAttributeGroup())->save($attribute, [ $attribute->getModelValueColumnName() => $value ]);
            $model->attributeValues()->save($attribute, [ $attribute->getModelValueColumnName() => $value ]);
        });

        return $model->load('attributeValues');
    }

    /**
     * Set reference to requested AttributeGroup.
     *
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group Reference to requested AttributeGroup.
     *
     * @return self
     */
    public function setAttributeGroup(AttributeGroup $attribute_group): self
    {
        $this->attribute_group = $attribute_group;

        return $this;
    }

    /**
     * Get reference to requested AttributeGroup.
     *
     * @return  \Softworx\RocXolid\Common\Models\AttributeGroup
     */
    public function getAttributeGroup()
    {
        return $this->attribute_group;
    }
}
