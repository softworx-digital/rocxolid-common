<?php

namespace Softworx\RocXolid\Common\Models\Tables\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// rocXolid fundamentals
use Softworx\RocXolid\Tables\AbstractCrudTable;
// relations
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// column types
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
// common models
use Softworx\RocXolid\Common\Models\File as FileModel;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $columns = [];

    // @todo - tmp crudable model, inac nejaky fileable contract
    public function handleUpload(UploadedFile $uploaded_file, CrudableModel $model, $model_attribute)
    {
        //$path = $uploaded_file->store(sprintf('files/%s/%s', $model->getUploadPath(), $model_attribute));
        // keep extension (was saving svg as txt)
        $path = $uploaded_file->storeAs(sprintf('files/%s/%s', $model->getUploadPath(), $model_attribute), sprintf('%s.%s', Str::random(40), $uploaded_file->getClientOriginalExtension()));
        $path_parts = pathinfo($path);

        if ($model->$model_attribute() instanceof MorphOne) {
            if ($model->$model_attribute()->exists()) {
                $model->$model_attribute->delete();
            }
        } elseif ($model->$model_attribute() instanceof MorphMany) {
            //
        } else {
            throw new \RuntimeException(sprintf('Invalid file relation type [%s] for [%s]->[%s]', get_class($model->$model_attribute()), get_class($model), $model_attribute));
        }

        // @todo - toto asi do nejakej model metody (resp trait pre model contract fileable?)
        $file = new FileModel();
        $file->model_attribute = $model_attribute;
        $file->storage_path = $path;
        $file->attachment_filename = $uploaded_file->getClientOriginalName();
        $file->original_filename = $uploaded_file->getClientOriginalName();
        $file->mime_type = $uploaded_file->getClientMimeType();
        $file->extension = $uploaded_file->getClientOriginalExtension();
        $file->is_model_primary = ($model->$model_attribute()->count() == 0);

        $model->$model_attribute()->save($file);

        $model->load($model_attribute);

        return $file;
    }
}
