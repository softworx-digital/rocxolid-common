<?php

namespace Softworx\RocXolid\Common\Models\Forms\File;

// relations
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
// rocXolid http requests
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid form fields
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid forms
use Softworx\RocXolid\Forms\Contracts\Form;
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left ajax-upload',
        'modal-footer-template' => 'upload',
    ];

    protected $fields = [
        'relation' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'model_attribute' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'model_type' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'model_id' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        // @todo needs title to show translated field in validation message
        'upload' => [
            'type' => FieldType\UploadFile::class,
            'options' => [
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
                'attributes' => [
                    'multiple' => false,
                ],
            ],
        ],
    ];

    public function adjustFormOptions(): Form
    {
        $this->options['data-on-action-complete'] = $this->getController()->getRoute('onUploadComplete');

        return $this;
    }

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');
        $fields['model_type']['options']['value'] = $this->getInputFieldValue('model_type');
        $fields['model_id']['options']['value'] = $this->getInputFieldValue('model_id');

        // @todo nicer
        $fake = $this->getModel();
        $model_attribute = $this->getInputFieldValue('model_attribute');

        $fake->resolvePolymorphism(collect([
            'model_type' => $this->getInputFieldValue('model_type'),
            'model_id' => $this->getInputFieldValue('model_id'),
        ]));

        if ($fake->parent->{$model_attribute}() instanceof MorphOne) {
        } elseif ($fake->parent->{$model_attribute}() instanceof MorphMany) {
            $fields['upload']['options']['attributes']['multiple'] = true;
        } else {
            throw new \RuntimeException(sprintf('Invalid file relation type [%s] for [%s]->[%s]', get_class($fake->parent->{$model_attribute}()), get_class($fake->parent), $model_attribute));
        }

        // @todo hotfixed
        $fields = $fake->parent->adjustUploadFormFields($fields, $model_attribute);

        return $fields;
    }

    protected function adjustUploadComplete(CrudRequest $request): Form
    {
        unset($this->fields['upload']);

        return $this;
    }
}
