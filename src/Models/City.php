<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;

class City extends AbstractCrudModel
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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}