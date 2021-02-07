<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid component contracts
use Softworx\RocXolid\Components\Contracts\Tableable;
// rocXolid common controllers
use Softworx\RocXolid\Common\Http\Controllers\Attribute\Controller as AttributeController;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Contracts\Attributable;
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * AttributeGroup model.
 * Represents group of attributes that can be dynamically added to a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class AttributeGroup extends AbstractCrudModel
{
    use SoftDeletes;

    protected const GENERAL_DATA_ATTRIBUTES = [
        'is_filterable',
        'model_type',
        'name',
        'code',
    ];

    protected const DESCRIPTION_DATA_ATTRIBUTES = [
        'description',
    ];

    protected const NOTE_DATA_ATTRIBUTES = [
        'note',
    ];

    /**
     * {@inheritDoc}
     */
    protected $attributable = [
        // Product::class,
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_filterable',
        'model_type',
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

    public function attributes(): Relations\HasMany
    {
        return $this->hasMany(Attribute::class)->orderBy(sprintf('%s.%s', app(Attribute::class)->getTable(), Attribute::POSITION_COLUMN));
    }

    public function getModelTypeTitle(): string
    {
        return app($this->model_type)->getClassNameTranslation();
    }

    public function makeModel($model_id): Attributable
    {
        return $this->model_type::find($model_id);
    }

    /**
     * Obtain available attributable models.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAvailableAttributables(): Collection
    {
        return $this->getAvailableAttributableTypes()->transform(function (string $type) {
            return app($type);
        });
    }

    /**
     * Obtain table component to view Attributes table.
     *
     * @return \Softworx\RocXolid\Components\Contracts\Tableable
     */
    public function getAttributesTableComponent(): Tableable
    {
        $attributes_controller = app(AttributeController::class, [
            'attribute_group' => $this,
        ]);

        return $attributes_controller->getTableComponent($attributes_controller->getTable(app(CrudRequest::class), 'index'));
    }

    public function getGeneralDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::GENERAL_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::GENERAL_DATA_ATTRIBUTES);
    }

    public function getDescriptionDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::DESCRIPTION_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::DESCRIPTION_DATA_ATTRIBUTES);
    }

    public function getNoteDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::NOTE_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::NOTE_DATA_ATTRIBUTES);
    }

    /**
     * Obtain model types that can have dynamic attributes.
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function getAvailableAttributableTypes(): Collection
    {
        return collect(config('rocXolid.common.attributes.attributables', []));
    }
}
