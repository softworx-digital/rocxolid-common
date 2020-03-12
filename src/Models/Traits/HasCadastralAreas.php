<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\CadastralArea;

trait HasCadastralAreas
{
    public function cadastralAreas()
    {
        return $this->hasMany(CadastralArea::class);
    }
}
