<?php

namespace Softworx\RocXolid\Common\Models\Forms\Attribute\Support;

// doctrine
use Doctrine\DBAL\Types\Type;
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
// rocXolid support
use Softworx\RocXolid\Forms\Support\FormFieldFactory as RocXolidFormFieldFactory;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type\BooleanRadio;
use Softworx\RocXolid\Forms\Fields\Type\Button;
use Softworx\RocXolid\Forms\Fields\Type\ButtonAnchor;
use Softworx\RocXolid\Forms\Fields\Type\ButtonGroup;
use Softworx\RocXolid\Forms\Fields\Type\ButtonSubmit;
use Softworx\RocXolid\Forms\Fields\Type\ButtonToolbar;
use Softworx\RocXolid\Forms\Fields\Type\Checkbox;
use Softworx\RocXolid\Forms\Fields\Type\CheckboxToggle;
use Softworx\RocXolid\Forms\Fields\Type\CollectionCheckbox;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\Colorpicker;
use Softworx\RocXolid\Forms\Fields\Type\Datepicker;
use Softworx\RocXolid\Forms\Fields\Type\Timepicker;
use Softworx\RocXolid\Forms\Fields\Type\DateTimepicker;
use Softworx\RocXolid\Forms\Fields\Type\FormFieldGroup;
use Softworx\RocXolid\Forms\Fields\Type\FormFieldGroupAddable;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Radio;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\Switchery;
use Softworx\RocXolid\Forms\Fields\Type\Textarea;
use Softworx\RocXolid\Forms\Fields\Type\WysiwygTextarea;
// rocXolid contracts
use Softworx\RocXolid\Contracts\EventDispatchable;
use Softworx\RocXolid\Forms\Contracts\Form;
use Softworx\RocXolid\Forms\Contracts\FormField;
use Softworx\RocXolid\Forms\Contracts\FormFieldable;
use Softworx\RocXolid\Forms\Contracts\FormFieldFactory as FormFieldFactoryContract;
// rocXolid common models
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
        Type::BOOLEAN       => CheckboxToggle::class,
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