<?php

namespace Softworx\RocXolid\Common\Models\Traits;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid common models
use Softworx\RocXolid\Common\Models\File;

/**
 * Trait to set up files relation to a model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
trait HasFiles
{
    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
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

    /**
     * Action to take if a file has been uploaded.
     *
     * @param \Softworx\RocXolid\Common\Models\File $file
     * @return \Softworx\RocXolid\Models\Contracts\Crudable
     * @todo events?
     */
    public function onFileUpload(File $file): Crudable
    {
        return $this;
    }

    /**
     * Adjust upload form fields.
     *
     * @param array $fields
     * @param string $model_attribute
     * @return array
     * @todo hotfixed
     */
    public function adjustUploadFormFields(array $fields, string $model_attribute): array
    {
        return $fields;
    }
}
