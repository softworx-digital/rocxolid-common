<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;

class Language extends AbstractCrudModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'is_admin_available',
        'iso_639_1'
    ];

    protected $relationships = [
    ];
}
