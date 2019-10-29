<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;
use Softworx\RocXolid\Common\Models\Traits\HasDistrict;

class City extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;
    use HasRegion;
    use HasDistrict;

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