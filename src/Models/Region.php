<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;

class Region extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'name',
        'description',
    ];

    protected $relationships = [
    ];
}