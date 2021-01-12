<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
use Softworx\RocXolid\Models\Contracts\Uploadable;
use Softworx\RocXolid\Models\Contracts\Downloadable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common services
use Softworx\RocXolid\Common\Services\FileUploadService;

/**
 * @todo cleanup
 */
class File extends AbstractCrudModel implements Uploadable, Downloadable
{
    use SoftDeletes;

    /**
     * Storage location subdirectory.
     * @todo method for this
     */
    const STORAGE_SUBDIR = 'files';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_model_primary',
        'name',
        'attachment_filename',
        'description',
    ];

    /**
     * {@inheritDoc}
     */
    protected $system = [
        'model_type',
        'model_id',
        'model_attribute',
        'model_attribute_position',
        'storage_path',
        'original_filename',
        'mime_type',
        'extension',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
    ];

    /**
     * Parent access relation.
     */
    public function parent()
    {
        return $this->morphTo('model');
    }

    /**
     * Obtain MIME type for given file.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mime_type;
        // return mime_content_type($this->getStoragePath());
    }

    /**
     * Check MIME type for given file.
     *
     * @param string $mime_type
     * @return bool
     */
    public function isMimeType(string $mime_type): bool
    {
        return preg_match(sprintf('/%s/', str_replace('/', '\/', $mime_type)), $this->mime_type);
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle(): string
    {
        return $this->name ?? $this->attachment_filename;
    }

    /**
     * {@inheritDoc}
     * @todo ugly
     */
    public function getRelativeUploadPath(): string
    {
        return sprintf(
            '%s/%s/%s/%s',
            static::STORAGE_SUBDIR,
            strtolower((new \ReflectionClass($this->parent))->getShortName()),
            $this->parent->getKey(),
            $this->model_attribute
        );
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadData(UploadedFile $uploaded_file): Uploadable
    {
        $this->attachment_filename = $uploaded_file->getClientOriginalName();
        $this->original_filename = $uploaded_file->getClientOriginalName();
        $this->mime_type = $uploaded_file->getClientMimeType();
        $this->extension = $uploaded_file->getClientOriginalExtension();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setStorageData(string $storage_path): Uploadable
    {
        $this->storage_path = $storage_path;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getStorageRelativePath(?string $param = null): string
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
    public function getStoragePath(?string $param = null): string
    {
        return storage_path(sprintf('%s/%s', FileUploadService::STORAGE_DIR, $this->getStorageRelativePath($param)));
    }

    /**
     * {@inheritDoc}
     */
    public function isFileValid(?string $param = null): bool
    {
        return $this->storage_path && file_exists($this->getStoragePath($param));
    }

    /**
     * {@inheritDoc}
     */
    public function content(?string $param = null): string
    {
        return Storage::get($this->getStorageRelativePath($param));
    }

    /**
     * {@inheritDoc}
     */
    public function getDownloadUrl(): string
    {
        return route('download', $this->getKey());
    }

    /**
     * {@inheritDoc}
     * @todo ugly
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->model_attribute = $data->get('model_attribute');

        return parent::onCreateBeforeSave($data);
    }
}
