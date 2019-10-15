<?php

namespace Softworx\RocXolid\Common\Models\Forms\Attribute\Support;

// doctrine
use Doctrine\DBAL\Types\Type;
// relations
use Illuminate\Database\Eloquent\Relations\Relation,
    Illuminate\Database\Eloquent\Relations\BelongsTo,
    Illuminate\Database\Eloquent\Relations\BelongsToMany,
    Illuminate\Database\Eloquent\Relations\HasMany,
    Illuminate\Database\Eloquent\Relations\HasManyThrough,
    Illuminate\Database\Eloquent\Relations\HasOne,
    Illuminate\Database\Eloquent\Relations\HasOneOrMany,
    Illuminate\Database\Eloquent\Relations\MorphMany,
    Illuminate\Database\Eloquent\Relations\MorphOne,
    Illuminate\Database\Eloquent\Relations\MorphTo,
    Illuminate\Database\Eloquent\Relations\MorphToMany;
// rocXolid support
use Softworx\RocXolid\Forms\Support\FormFieldFactory as RocXolidFormFieldFactory;
// field types
use Softworx\RocXolid\Forms\Fields\Type\BooleanRadio,
    Softworx\RocXolid\Forms\Fields\Type\Button,
    Softworx\RocXolid\Forms\Fields\Type\ButtonAnchor,
    Softworx\RocXolid\Forms\Fields\Type\ButtonGroup,
    Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit,
    Softworx\RocXolid\Forms\Fields\Type\ButtonToolbar,
    Softworx\RocXolid\Forms\Fields\Type\Checkable,
    Softworx\RocXolid\Forms\Fields\Type\Checkbox,
    Softworx\RocXolid\Forms\Fields\Type\ChildForm,
    Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox,
    Softworx\RocXolid\Forms\Fields\Type\CollectionSelect,
    Softworx\RocXolid\Forms\Fields\Type\Collection,
    Softworx\RocXolid\Forms\Fields\Type\Colorpicker,
    Softworx\RocXolid\Forms\Fields\Type\Datepicker,
    Softworx\RocXolid\Forms\Fields\Type\Timepicker,
    Softworx\RocXolid\Forms\Fields\Type\DateTimepicker,
    Softworx\RocXolid\Forms\Fields\Type\Entity,
    Softworx\RocXolid\Forms\Fields\Type\FormFieldGroup,
    Softworx\RocXolid\Forms\Fields\Type\FormFieldGroupAddable,
    Softworx\RocXolid\Forms\Fields\Type\Input,
    Softworx\RocXolid\Forms\Fields\Type\Radio,
    Softworx\RocXolid\Forms\Fields\Type\Repeated,
    Softworx\RocXolid\Forms\Fields\Type\Select,
    Softworx\RocXolid\Forms\Fields\Type\StaticField,
    Softworx\RocXolid\Forms\Fields\Type\Switchery,
    Softworx\RocXolid\Forms\Fields\Type\Textarea,
    Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
// contracts
use Softworx\RocXolid\Contracts\EventDispatchable,
    Softworx\RocXolid\Forms\Contracts\Form,
    Softworx\RocXolid\Forms\Contracts\FormField,
    Softworx\RocXolid\Forms\Contracts\FormFieldable,
    Softworx\RocXolid\Forms\Contracts\FormFieldFactory as FormFieldFactoryContract;
// common models
use Softworx\RocXolid\Common\Models\Attribute;
/**
 *
 */
class FormFieldFactory extends RocXolidFormFieldFactory implements FormFieldFactoryContract
{
    /**
     * Mappings for DB column types.
     *
     * @var array
     */
    protected static $fields_mapping = [
        Type::BOOLEAN       => Switchery::class,
        Type::INTEGER       => Input::class,
        Type::DECIMAL       => Input::class,
        Type::STRING        => Input::class,
        Type::TEXT          => Textarea::class,
        'enum'              => CollectionSelect::class,
    ];

    public function makeAttributeFieldDefinition(Attribute $attribute, $rules = []): array
    {
        $type = $this->getAttributeFieldTypeClass($attribute);

        /*
        if ($attribute->getNotnull())
        {
            $rules[] = 'required';
        }

        if ($attribute->getLength())
        {
            $rules[] = 'max:' . $attribute->getLength();
        }
        */

        $definition = [];

        switch ($attribute->type)
        {
            case Type::INTEGER:
                $rules[] = 'nullable';
                $rules[] = 'numeric';
                $rules[] = sprintf('min:%s', -pow(10, 10));
                $rules[] = sprintf('max:%s', pow(10, 10));
                break;
            case Type::DECIMAL:
                $rules[] = 'nullable';
                $rules[] = 'numeric';
                $rules[] = sprintf('min:%s', -pow(10, 8));
                $rules[] = sprintf('max:%s', pow(10, 8));
                break;
            case Type::BOOLEAN:
                $rules[] = 'in:0,1';
                break;
            case 'enum':
                $definition['options'] = [
                    'collection' => $attribute->attributeValues->pluck('name', 'id'),
                    'show_null_option' => true,
                ];
                break;
        }

        return array_merge_recursive([
            'type' => $type,
            'options' => [
                'label' => [
                    'title' => $attribute->getTitle(),
                ],
                'validation' => [
                    'rules' => $rules,
                ],
            ],
        ], $definition);
    }

    protected function getAttributeFieldTypeClass(Attribute $attribute)
    {
        if (!array_key_exists($attribute->type, self::$fields_mapping))
        {
            throw new \InvalidArgumentException(sprintf('Undefined field type for attribute [%s] type [%s]', $attribute->id, $attribute->type));
        }

        $type = self::$fields_mapping[$attribute->type];

        return $type;
    }
}