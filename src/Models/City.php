<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;
use Softworx\RocXolid\Common\Models\Traits\HasDistrict;
use Softworx\RocXolid\Common\Models\Traits\HasCadastralAreas;

class City extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;
    use HasRegion;
    use HasDistrict;
    use HasCadastralAreas;

    protected $fillable = [
        'type',
        'code',
        'name',
        'zip',
        'description',
    ];

    protected $relationships = [
    ];

    protected $enums = [
        'type',
    ];

    public function getSelectOption()
    {
        return sprintf(
            "%s (%s)",
            $this->name,
            $this->district()->exists() ? $this->district->getTitle() : '-'
        );
    }
}
