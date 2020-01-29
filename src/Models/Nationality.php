<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;

class Nationality extends AbstractCrudModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $relationships = [
    ];
}
