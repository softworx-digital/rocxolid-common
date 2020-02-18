<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\CadastralArea;

trait HasCadastralArea
{
    public function cadastralArea()
    {
        return $this->belongsTo(CadastralArea::class);
    }
}
