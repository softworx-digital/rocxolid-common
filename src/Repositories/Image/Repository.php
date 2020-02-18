<?php

namespace Softworx\RocXolid\Common\Repositories\Image;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
// third party
use Intervention\Image\Exception\NotReadableException;
// rocXolid fundamentals
use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// column types
use Softworx\RocXolid\Repositories\Columns\Type\Text;
use Softworx\RocXolid\Repositories\Columns\Type\ModelRelation;
// common models
use Softworx\RocXolid\Common\Models\Image;

/**
 *
 */
class Repository extends AbstractCrudRepository
{
    protected $columns = [];

    // @todo - tmp crudable model, inac nejaky imageable contract
    public function handleUpload(UploadedFile $uploaded_file, CrudableModel $model, $model_attribute)
    {
        // $path = $uploaded_file->store(sprintf('images/%s/%s', $model->getUploadPath(), $model_attribute));
        // keep extension (was saving svg as txt)
        $path = $uploaded_file->storeAs(sprintf('images/%s/%s', $model->getUploadPath(), $model_attribute), sprintf('%s.%s', Str::random(40), $uploaded_file->getClientOriginalExtension()));
        $path_parts = pathinfo($path);

        try {
            $intervention_image = \InterventionImage::make(storage_path(sprintf('app/%s', $path)));
            $sizes = [
                'original' => [
                    'width' => $intervention_image->width(),
                    'height' => $intervention_image->height(),
                    'ratio' => $intervention_image->width() / $intervention_image->height(),
                ]
            ];

            foreach ($model->getImageSizes($model_attribute) as $directory => $options) {
                $intervention_image = \InterventionImage::make(storage_path(sprintf('app/%s', $path)));
                $storage_directory = storage_path(sprintf('app/%s/%s', $path_parts['dirname'], $directory));

                if (!File::exists($storage_directory)) {
                    File::makeDirectory($storage_directory);
                }

                $methods = is_array($options['method']) ? $options['method'] : [ $options['method'] ];

                $options['height'] = $options['height'] ?? round($options['width'] / $sizes['original']['ratio']);
                $options['width'] = $options['width'] ?? round($options['height'] / $sizes['original']['ratio']);

                foreach ($methods as $method) {
                    if (in_array($method, [ 'resize', 'fit' ])) {
                        $intervention_image->$method($options['width'], $options['height'], function ($constraint) use ($options) {
                            if (isset($options['constraints'])) {
                                foreach ($options['constraints'] as $constraint_method) {
                                    $constraint->$constraint_method();
                                }
                            }
                        });
                    } else {
                        $intervention_image->$method($options['width'], $options['height']);
                    }
                }

                $intervention_image->save(sprintf('%s/%s', $storage_directory, $path_parts['basename']));
            }
        } catch (NotReadableException $e) {
            $sizes = [
                'original' => [
                    'width' => 'unknown',
                    'height' => 'unknown',
                ]
            ];

            foreach ($model->getImageSizes($model_attribute) as $directory => $options) {
                $storage_directory = storage_path(sprintf('app/%s/%s', $path_parts['dirname'], $directory));

                if (!File::exists($storage_directory)) {
                    File::makeDirectory($storage_directory);
                }

                Storage::copy($path, sprintf('%s/%s/%s', $path_parts['dirname'], $directory, $path_parts['basename']));
            }
        }

        if ($model->$model_attribute() instanceof MorphOne) {
            if ($model->$model_attribute()->exists()) {
                $model->$model_attribute->delete();
            }
        } elseif ($model->$model_attribute() instanceof MorphMany) {
            //
        } else {
            throw new \RuntimeException(sprintf('Invalid image relation type [%s] for [%s]->[%s]', get_class($model->$model_attribute()), get_class($model), $model_attribute));
        }

        // @todo - toto asi do nejakej model metody (resp trait pre model contract imageable?)
        $image = new Image();
        $image->model_attribute = $model_attribute;
        $image->storage_path = $path;
        $image->original_filename = $uploaded_file->getClientOriginalName();
        $image->mime_type = $uploaded_file->getClientMimeType();
        $image->extension = $uploaded_file->getClientOriginalExtension();
        $image->sizes = json_encode($sizes + $model->getImageSizes($model_attribute));
        $image->is_model_primary = ($model->$model_attribute()->count() == 0);

        $model->$model_attribute()->save($image);

        $model->load($model_attribute);

        return $image;
    }
}
