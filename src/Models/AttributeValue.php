<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Attribute;

class AttributeValue extends AbstractCrudModel
{
    use SoftDeletes;

    const POSITION_COLUMN = 'attribute_position';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'attribute_id',
        'name',
        'description',
        'note',
    ];

    protected $relationships = [
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}