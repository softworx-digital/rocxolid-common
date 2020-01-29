<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;

class Locale extends AbstractCrudModel
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'local_name'
    ];

    protected $relationships = [
    ];
}
