<?php

namespace Softworx\RocXolid\Common\Models;

use Softworx\RocXolid\Models\AbstractCrudModel;
// common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable;
// common models
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 * AttributeModel model.
 * @todo: ???
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class AttributeModel extends AbstractCrudModel
{
    /**
     * {@inheritDoc}
     */
    protected $guarded = [
        //'id'
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'attribute_id',
        'attribute_value_id',
        'value_boolean',
        'value_integer',
        'value_decimal',
        'value_string',
        'value_text',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        //'attributeGroup',
    ];

    /*
    public function attributeGroup()
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function isType(string $type): bool
    {
        return $type == $this->type;
    }

    public function isMultiple(): bool
    {
        return $this->is_multiple;
    }

    public function getModelValue(Attributable $model)
    {
        return __METHOD__;
    }
    */
}
