<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations;
// rocXolid common models
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\Attribute;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 * @todo documentation (with associated contracts)
 */
trait HasDynamicAttributes
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

    public function attributeValues(): Relations\MorphToMany
    {
        return $this->morphToMany(Attribute::class, 'model', 'model_has_attributes')->withPivot($this->getPivotExtra());
    }

    public function attributeGroupValues(AttributeGroup $attribute_group): Relations\MorphToMany
    {
        return $this->morphToMany(Attribute::class, 'model', 'model_has_attributes')
            ->where('attributes.attribute_group_id', $attribute_group->getKey())
            ->withPivot($this->getPivotExtra());
    }

    public function attributeGroups(): Collection
    {
        return AttributeGroup::whereJsonContains('model_type', static::class)->get();
    }

    public function allAttributeValues(): Collection
    {
        return $this->attributeGroups()->transform(function (AttributeGroup $attribute_group) {
            return [
                'id' => $attribute_group->getKey(),
                'title' => $attribute_group->getTitle(),
                'values' => $attribute_group->attributes()->get()->transform(function (Attribute $attribute) {
                    return [
                        'id' => $attribute->getKey(),
                        'title' => $attribute->getTitle(),
                        'value' => $this->attributeValue($attribute, true)
                    ];
                })
            ];
        });
    }

    // @todo ugly
    public function attributeValue(Attribute $attribute, $raw = false)
    {
        if ($pivot_attribute = $this->attributeValues->find(['attribute_id' => $attribute->getKey()])->first()) {
            switch ($pivot_attribute->type) {
                case 'enum':
                    $attribute_value = AttributeValue::find($pivot_attribute->pivot->attribute_value_id);

                    return $attribute_value ? ($raw ? $attribute_value->getKey() : $attribute_value->getTitle()) : null;
                case 'integer':
                case 'decimal':
                    $column = sprintf('value_%s', $pivot_attribute->type);
                    $value = $pivot_attribute->pivot->$column;

                    if ($raw) {
                        return $value;
                    } else {
                        $nf = new \NumberFormatter(app()->getLocale(), \NumberFormatter::DECIMAL);
                        $nf->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, 2);
                        $nf->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 8);

                        return filled($attribute->units) ? sprintf('%s %s', $nf->format($value), $attribute->units) : $nf->format($value);
                    }
                default:
                    $column = sprintf('value_%s', $pivot_attribute->type);
                    $value = $pivot_attribute->pivot->$column;

                    return filled($attribute->units) ? sprintf('%s %s', $value, $attribute->units) : $value;
            }
        }

        return null;
    }

    protected static function getPivotExtra(): array
    {
        return static::$pivot_extra;
    }
}
