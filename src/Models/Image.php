<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes,
    Illuminate\Support\Facades\Storage;
// rocXolid fundamentals
use Softworx\RocXolid\Models\AbstractCrudModel;
// common models
use Softworx\RocXolid\Common\Models\File;
/**
 *
 */
class Image extends File
{
    use SoftDeletes;

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
}