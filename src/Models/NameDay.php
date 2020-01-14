<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;

class NameDay extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'country_id',
        'day',
        'day_month',
        'month',
        'name'
    ];

    protected $relationships = [
        'country',
    ];

    public function getDate()
    {
        return sprintf('%s.%s.', $this->day_month, $this->month);
    }
}
