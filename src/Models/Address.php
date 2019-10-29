<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;
use Softworx\RocXolid\Common\Models\Traits\HasDistrict;

class Address extends AbstractCrudModel
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
        'country',
        'region',
        'district',
        'street',
        'po_box',
        'zip',
        'latitude',
        'longitude',
    ];

    protected $relationships = [
    ];
}