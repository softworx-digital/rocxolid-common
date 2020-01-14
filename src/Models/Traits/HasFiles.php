<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Softworx\RocXolid\Common\Models\File;

trait HasFiles
{
    public function files()
    {
        return $this
            ->morphMany(File::class, 'model')
            ->where(sprintf('%s.model_attribute', (new File())->getTable()), 'files')
            ->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }

    public function filePrimary()
    {
        return $this
            ->morphOne(File::class, 'model')
            ->where(sprintf('%s.model_attribute', (new File())->getTable()), 'files')
            ->where(sprintf('%s.is_model_primary', (new File())->getTable()), 1);
    }
}
