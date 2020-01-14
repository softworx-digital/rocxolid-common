<?php

namespace Softworx\RocXolid\Common\Repositories\AttributeModel;

// rocXolid contracts
use Softworx\RocXolid\Models\Contracts\Crudable as CrudableModel;
// rocXolid fundamentals
use Softworx\RocXolid\Repositories\AbstractCrudRepository;
// common support
use Softworx\RocXolid\Common\Models\Forms\Attribute\Support\FormFieldFactory as AttributeFormFieldFactory;
// common models
use Softworx\RocXolid\Common\Models\Attribute;
use Softworx\RocXolid\Common\Models\AttributeValue;

/**
 *
 */
class Repository extends AbstractCrudRepository
{
    protected $form_field_factory = AttributeFormFieldFactory::class;

    protected $filters = [];

    protected $columns = [];

    public function updateModel(array $data, CrudableModel $model, $action): CrudableModel
    {
        $model->attributeValues()->detach();

        foreach ($data as $attribute_id => $value) {
            $attribute = Attribute::findOrFail($attribute_id);

            switch ($attribute->type) {
                case 'enum':
                    $column = 'attribute_value_id';
                    break;
                default:
                    $column = sprintf('value_%s', $attribute->type);
                    break;
            }

            $model->attributeValues()->save($attribute, [ $column => $value ]);
            $model->load('attributeValues');
        }

        return $model;
    }
}
