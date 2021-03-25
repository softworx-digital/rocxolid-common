<?php

namespace Softworx\RocXolid\Common\Models\Forms\Attribute\Support;

use Doctrine\DBAL\Types\Type;
// rocXolid support
use Softworx\RocXolid\Forms\Builders\FormFieldFactory as RocXolidFormFieldFactory;
// rocXolid field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid contracts
use Softworx\RocXolid\Forms\Builders\Contracts\FormFieldFactory as FormFieldFactoryContract;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Attribute;

/**
 * @todo revise
 */
class FormFieldFactory extends RocXolidFormFieldFactory implements FormFieldFactoryContract
{
    /**
     * Mappings for DB column types.
     *
     * @var array
     */
    protected static $fields_mapping = [
        Type::BOOLEAN       => FieldType\CheckboxToggle::class,
        Type::INTEGER       => FieldType\Input::class,
        Type::DECIMAL       => FieldType\Input::class,
        Type::STRING        => FieldType\Input::class,
        Type::TEXT          => FieldType\Textarea::class,
        'enum'              => FieldType\CollectionSelect::class,
    ];

    public function makeAttributeFieldDefinition(Attribute $attribute, $rules = []): array
    {
        $type = $this->getAttributeFieldTypeClass($attribute);

        $definition = [];

        switch ($attribute->type) {
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
                ];
                break;
        }

        $definition = array_merge_recursive([
            'type' => $type,
            'options' => [
                'label' => [
                    'title-translated' => $attribute->getTitle(),
                ],
                'validation' => [
                    'rules' => $rules,
                ],
            ],
        ], $definition);

        if (filled($attribute->units)) {
            $definition = array_merge_recursive([
                'options' => [
                    'units' => $attribute->units,
                ],
            ], $definition);
        }

        return $definition;
    }

    protected function getAttributeFieldTypeClass(Attribute $attribute)
    {
        if (!array_key_exists($attribute->type, self::$fields_mapping)) {
            throw new \InvalidArgumentException(sprintf('Undefined field type for attribute [%s] type [%s]', $attribute->getKey(), $attribute->type));
        }

        $type = self::$fields_mapping[$attribute->type];

        return $type;
    }
}
