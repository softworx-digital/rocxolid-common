<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;

class District extends AbstractCrudModel
{
    use SoftDeletes;
    use HasRegion;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $relationships = [
    ];
}
