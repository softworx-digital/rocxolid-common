<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\Traits\HasCity;

class CadastralArea extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCity;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $relationships = [
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
