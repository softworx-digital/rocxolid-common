<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Uploadable;
use Softworx\RocXolid\Models\Contracts\Downloadable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common services
use Softworx\RocXolid\Common\Services\FileUploadService;

/**
 *
 */
class File extends AbstractCrudModel implements Uploadable, Downloadable
{
    use SoftDeletes;

    protected $fillable = [
        'is_model_primary',
        'name',
        'attachment_filename',
        'description',
    ];

    protected $system = [
        'model_type',
        'model_id',
        'model_attribute',
        'model_attribute_position',
        'storage_path',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $relationships = [
    ];

    public function parent()
    {
        return $this->morphTo('model');
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return !empty($this->name) ? $this->name : $this->attachment_filename;
    }

    /**
     * {@inheritDoc}
     */
    public function getRelativeUploadPath(): string
    {
        return sprintf('%s/%s/%s', strtolower((new \ReflectionClass($this->parent))->getShortName()), $this->parent->getKey(), $this->model_attribute);
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadData(UploadedFile $uploaded_file, string $storage_path): Uploadable
    {
        $this->storage_path = $storage_path;
        $this->original_filename = $uploaded_file->getClientOriginalName();
        $this->mime_type = $uploaded_file->getClientMimeType();
        $this->extension = $uploaded_file->getClientOriginalExtension();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function content($param = null): string
    {
        if (is_null($param)) {
            return Storage::get($this->storage_path);
        }

        $pathinfo = pathinfo($this->storage_path);

        return Storage::get(sprintf('%s/%s/%s', $pathinfo['dirname'], $param, $pathinfo['basename']));
    }

    /**
     * {@inheritDoc}
     */
    public function getStorageRelativePath($param = null): string
    {
        if (is_null($param)) {
            return $this->storage_path;
        }

        $pathinfo = pathinfo($this->storage_path);

        return sprintf('%s/%s/%s', $pathinfo['dirname'], $param, $pathinfo['basename']);
    }

    /**
     * {@inheritDoc}
     */
    public function getStoragePath($param = null): string
    {
        return storage_path(sprintf('%s/%s', FileUploadService::STORAGE_DIR, $this->getStorageRelativePath($param)));
    }

    /**
     * {@inheritDoc}
     */
    public function getDownloadUrl(): string
    {
        return route('download', $this->getKey());
    }
}
