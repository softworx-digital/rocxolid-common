<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;

/**
 *
 */
class File extends AbstractCrudModel
{
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

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

    public function getTitle()
    {
        return !empty($this->name) ? $this->name : $this->attachment_filename;
    }

    public function content($param = null)
    {
        if (is_null($param)) {
            return Storage::get($this->storage_path);
        }

        $pathinfo = pathinfo($this->storage_path);

        return Storage::get(sprintf('/%s/%s/%s', $pathinfo['dirname'], $param, $pathinfo['basename']));
    }

    public function getPath($param = null)
    {
        if (is_null($param)) {
            return sprintf('/storage/%s', $this->storage_path);
        }

        $pathinfo = pathinfo($this->storage_path);

        return sprintf('/storage/%s/%s/%s', $pathinfo['dirname'], $param, $pathinfo['basename']);
    }

    public function getDownloadUrl()
    {
        return route('download', $this->id);
    }
}
