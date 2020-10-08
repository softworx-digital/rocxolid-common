<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\File;

/**
 * Trait to set up file relation to a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
trait HasFile
{
    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'model')->where(sprintf('%s.model_attribute', (new File())->getTable()), 'file')->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }

    /**
     * Action to take if a file has been uploaded.
     *
     * @param \Softworx\RocXolid\Common\Models\File $file
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     * @todo: events?
     */
    public function onFileUpload(File $file): Crudable
    {
        return $this;
    }

    /**
     * Action to take if a file has been destroyed.
     *
     * @param \Softworx\RocXolid\Common\Models\File $file
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     * @todo: events?
     */
    public function onFileDestroyed(File $file): Crudable
    {
        return $this;
    }
}
