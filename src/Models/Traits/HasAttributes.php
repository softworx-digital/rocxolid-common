<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
// common models
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\Attribute;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 *
 */
trait HasAttributes
{
    protected $_attributes = null;

    protected static $pivot_extra = [
        'attribute_id',
        'attribute_value_id',
        'value_boolean',
        'value_integer',
        'value_decimal',
        'value_string',
        'value_text',
    ];

    public function attributeValues(): Relation
    {
        return $this->morphToMany(Attribute::class, 'model', 'model_has_attributes')->withPivot($this->getPivotExtra());
    }

    public function attributeGroups(): Collection
    {
        return AttributeGroup::where('model_type', static::class)->get();
    }

    public function attributeValue(Attribute $attribute, $raw = false)
    {
        if ($pivot_attribute = $this->attributeValues->find(['attribute_id' => $attribute->id])->first()) {
            switch ($pivot_attribute->type) {
                case 'enum':
                    $attribute_value = AttributeValue::find($pivot_attribute->pivot->attribute_value_id);
                    return $attribute_value ? ($raw ? $attribute_value->id : $attribute_value->getTitle()) : null;
                case 'integer':
                case 'decimal':
                    $column = sprintf('value_%s', $pivot_attribute->type);
                    return $raw ? $pivot_attribute->pivot->$column : number_format($pivot_attribute->pivot->$column, 2, ',', ' ');
                default:
                    $column = sprintf('value_%s', $pivot_attribute->type);
                    return $pivot_attribute->pivot->$column;
            }
        }

        return null;
    }

    protected static function getPivotExtra(): array
    {
        return static::$pivot_extra;
    }
}
