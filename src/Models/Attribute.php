<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid component contracts
use Softworx\RocXolid\Components\Contracts\Tableable;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\AttributeValue\Controller as AttributeValueController;
// rocXolid common contracts
use Softworx\RocXolid\Common\Models\Contracts\Attributable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\AttributeGroup;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 * Attribute model.
 * Represents dynamically addable data to Attributable models.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Attribute extends AbstractCrudModel
{
    use SoftDeletes;

    const POSITION_COLUMN = 'attribute_group_position';

    const TYPES = [
        'boolean',
        'integer',
        'decimal',
        'string',
        'text',
        'enum',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'attribute_group_id',
        'type',
        //'is_multiple',
        'name',
        'code',
        'units',
        'description',
        'note',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'attributeGroup',
    ];

    /**
     * {@inheritDoc}
     */
    protected $enums = [
        'type',
    ];

    /**
     * Global scope to get Attributes of given AttributeGroup.
     *
     * @param \Softworx\RocXolid\Common\Models\AttributeGroup $attribute_group
     */
    public static function bootAssociatedAttributeGroup(AttributeGroup $attribute_group)
    {
        static::addGlobalScope('attribute_group', function (Builder $builder) use ($attribute_group) {
            $builder->where('attribute_group_id', $attribute_group->getKey());
        });
    }

    /**
     * AttributeGroup reference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attributeGroup(): Relations\BelongsTo
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    /**
     * AttributeValues reference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeValues(): Relations\HasMany
    {
        return $this->hasMany(AttributeValue::class)->orderBy(sprintf('%s.%s', app(AttributeValue::class)->getTable(), AttributeValue::POSITION_COLUMN));
    }

    /**
     * Obtain formatted attribute values.
     *
     * @return string
     */
    public function formatAttributeValues(): string
    {
        return $this->attributeValues->pluck('name')->join(', ');
    }

    /**
     * Obtain table component to view AttributeValues table.
     *
     * @return \Softworx\RocXolid\Components\Contracts\Tableable
     */
    public function getAttributeValuesTableComponent(): Tableable
    {
        $attribute_values_controller = app(AttributeValueController::class, [
            'attribute' => $this,
        ]);

        return $attribute_values_controller->getTableComponent($attribute_values_controller->getTable(app(CrudRequest::class), 'index'));
    }

    /**
     * Check if the Attribute is of given type.
     *
     * @param string $type
     * @return boolean
     */
    public function isType(string $type): bool
    {
        return $type === $this->type;
    }

    /**
     * Check if the Attribute can have multiple values.
     *
     * @return boolean
     */
    public function isMultiple(): bool
    {
        return $this->is_multiple;
    }

    /**
     * Obtain appropriate column name for AttributeModel.
     *
     * @return string
     */
    public function getModelValueColumnName(): string
    {
        switch ($this->type) {
            case 'enum':
                return 'attribute_value_id';
            default:
                return sprintf('value_%s', $this->type);
        }
    }
}
