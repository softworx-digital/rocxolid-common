<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Attribute;
use Softworx\RocXolid\Commerce\Models\Product;

class AttributeGroup extends AbstractCrudModel
{
    use SoftDeletes;

    protected $attributable = [
        Product::class,
    ];

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'model_type',
        'name',
        'description',
        'note',
    ];

    protected $relationships = [
    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class)->orderBy(sprintf('%s.%s', (new Attribute())->getTable(), Attribute::POSITION_COLUMN));
    }

    public function getModelType()
    {
        if (($class = $this->model_type) && class_exists($class))
        {
            return $class::make()->getModelViewerComponent()->translate('model.title.singular');
        }

        return null;
    }

    public function makeModel($model_id)
    {
        $class = $this->model_type;

        return $class::find($model_id);
    }

    public function getAttributableModels()
    {
        $models = new Collection();

        foreach ($this->attributable as $class)
        {
            //$models->put(Str::kebab((new \ReflectionClass($class))->getShortName()), $class);
            //$short_name = (new \ReflectionClass($class))->getShortName();
            $models->put($class, $class::make()->getModelViewerComponent()->translate('model.title.singular'));
        }

        return $models;
    }
}