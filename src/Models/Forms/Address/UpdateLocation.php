<?php

namespace Softworx\RocXolid\Common\Models\Forms\Address;

use Illuminate\Support\Collection;
// rocXolid model scopes
use Softworx\RocXolid\Models\Scopes\Owned as OwnedScope;
// rocXolid form contracts
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
// rocXolid form field types
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common filters
use Softworx\RocXolid\Common\Filters;
// rocXolid common models
use Softworx\RocXolid\Common\Models;

class UpdateLocation extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
        'section' => 'location',
    ];

    protected $fields = [
        'relation' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_attribute' => [
            'type' => FieldType\Hidden::class,
            'options' => [
                'validation' => 'required',
            ],
        ],
        'model_type' => [
            'type' => FieldType\Hidden::class,
            'options' => [],
        ],
        'street_name' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'street_name',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                        'max:255',
                    ],
                ],
            ],
        ],
        'street_no' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'street_no',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'city_id' => [
            'type' => FieldType\ModelRelationSelectAutocomplete::class,
            'options' => [
                'relation' => 'city',
                'change-action' => 'formReload',
                'label' => [
                    'title' => 'city',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:cities,id',
                    ],
                ],
            ],
        ],
        'region_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Models\Region::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'region',
                ],
                'attributes' => [
                    'title' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:regions,id',
                    ],
                ],
            ],
        ],
        'district_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Models\District::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'district',
                ],
                'attributes' => [
                    'title' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:districts,id',
                    ],
                ],
            ],
        ],
        'cadastral_area_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Models\CadastralArea::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'cadastralArea',
                ],
                'attributes' => [
                    'title' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        // 'required',
                        'nullable',
                        'exists:cadastral_areas,id',
                    ],
                ],
            ],
        ],
        'country_id' => [
            'type' => FieldType\CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Models\Country::class,
                    'column' => 'name',
                ],
                'label' => [
                    'title' => 'country',
                ],
                'attributes' => [
                    'title' => 'select',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'exists:countries,id',
                    ],
                ],
            ],
        ],
        'latitude' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'latitude',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                        'latitude',
                    ],
                ],
            ],
        ],
        'longitude' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'longitude',
                ],
                'validation' => [
                    'rules' => [
                        'nullable',
                        'longitude',
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

        // city
        $city = Models\City::find($this->getInputFieldValue('city_id')) ?? $this->getModel()->city;
        /*
        $fields['city_id']['options']['collection']['filters'][] = [
            'class' => CityHasCadastralArea::class,
            'data' => null,
        ];
        */

        if (is_null($city)) {
            $fields['region_id']['options']['collection'] = collect();
            $fields['district_id']['options']['collection'] = collect();
            $fields['country_id']['options']['collection'] = collect();
            $fields['cadastral_area_id']['options']['collection'] = collect();
        } else {
            // region
            $fields['region_id']['options']['attributes']['title'] = null;
            $fields['region_id']['options']['collection'] = [
                'model' => Models\Region::class,
                'column' => 'name',
                'filters' => [['class' => Filters\CityBelongsTo::class, 'data' => $city]]
            ];
            // district
            $fields['district_id']['options']['attributes']['title'] = null;
            $fields['district_id']['options']['collection'] = [
                'model' => Models\District::class,
                'column' => 'name',
                'filters' => [['class' => Filters\CityBelongsTo::class, 'data' => $city]]
            ];
            // country
            $fields['country_id']['options']['attributes']['title'] = null;
            $fields['country_id']['options']['collection'] = [
                'model' => Models\Country::class,
                'column' => 'name',
                'filters' => [['class' => Filters\CityBelongsTo::class, 'data' => $city]]
            ];
            // cadastral area
            $fields['cadastral_area_id']['options']['attributes']['title'] = null;
            $fields['cadastral_area_id']['options']['collection'] = [
                'model' => Models\CadastralArea::class,
                'column' => 'name',
                'filters' => [['class' => Filters\BelongsToCity::class, 'data' => $city]]
            ];
        }

        return $fields;
    }
}
