<?php

namespace Softworx\RocXolid\Common\Models\Forms\Image;

// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type\Hidden;

class Upload extends Create
{
    protected $fields = [
        'relation' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'model_attribute' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'model_type' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'model_id' => [
            'type' => Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');
        $fields['model_type']['options']['value'] = $this->getInputFieldValue('model_type');
        $fields['model_id']['options']['value'] = $this->getInputFieldValue('model_id');

        return $fields;
    }
}
