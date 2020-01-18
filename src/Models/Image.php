<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common models
use Softworx\RocXolid\Common\Models\File;

/**
 *
 */
class Image extends File
{
    // use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'is_model_primary',
        //'name',
        'alt',
        //'description',
    ];

    protected $relationships = [
    ];

    public function parent()
    {
        return $this->morphTo('model');
    }
}
