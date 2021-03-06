<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;

class Region extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];

    protected $relationships = [
    ];
}
