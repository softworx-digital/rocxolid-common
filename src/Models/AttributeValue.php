<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * AttributeGroup model.
 * Represents value of an attributes that can be dynamically added to a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class AttributeValue extends AbstractCrudModel
{
    use SoftDeletes;

    const POSITION_COLUMN = 'attribute_position';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'attribute_id',
        'name',
        'code',
        'description',
        'note',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
    ];

    /**
     * Global scope to get AttributeValues of given Attribute.
     *
     * @param \Softworx\RocXolid\Common\Models\Attribute $attribute
     */
    public static function bootAssociatedAttribute(Attribute $attribute)
    {
        static::addGlobalScope('attribute', function (Builder $builder) use ($attribute) {
            $builder->where('attribute_id', $attribute->getKey());
        });
    }

    /**
     * Attribute reference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute(): Relations\BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
