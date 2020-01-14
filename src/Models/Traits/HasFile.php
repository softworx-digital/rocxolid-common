<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\File;

trait HasFile
{
    public function file()
    {
        return $this->morphOne(File::class, 'model')->where(sprintf('%s.model_attribute', (new File())->getTable()), 'file')->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }
}
