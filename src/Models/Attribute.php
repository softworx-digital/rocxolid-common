<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
// common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable;
// common models
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 *
 */
class Attribute extends AbstractCrudModel
{
    use SoftDeletes;

    const POSITION_COLUMN = 'attribute_group_position';

    protected $fillable = [
        'attribute_group_id',
        'type',
        //'is_multiple',
        'name',
        'description',
        'note',
    ];

    protected $relationships = [
        'attributeGroup',
    ];

    public function attributeGroup()
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class)->orderBy(sprintf('%s.%s', (new AttributeValue())->getTable(), AttributeValue::POSITION_COLUMN));
    }

    public function isType(string $type): bool
    {
        return $type == $this->type;
    }

    public function isMultiple(): bool
    {
        return $this->is_multiple;
    }
}
