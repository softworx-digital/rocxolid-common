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
use Softworx\RocXolid\Forms\Fields\Type\Hidden;
use Softworx\RocXolid\Forms\Fields\Type\Input;
use Softworx\RocXolid\Forms\Fields\Type\Select;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelect;
use Softworx\RocXolid\Forms\Fields\Type\CollectionSelectAutocomplete;
// rocXolid common filters
use Softworx\RocXolid\Common\Filters\CityBelongsTo;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Country;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\District;
use Softworx\RocXolid\Common\Models\City;

class Update extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'update',
        'class' => 'form-horizontal form-label-left',
    ];

    protected $fields = [
        'street_name' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'street_name',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'street_no' => [
            'type' => Input::class,
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
        'zip' => [
            'type' => Input::class,
            'options' => [
                'label' => [
                    'title' => 'zip',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                        'max:255',
                    ],
                ],
            ],
        ],
        'city_id' => [
            'type' => CollectionSelectAutocomplete::class,
            'options' => [
                'collection' => [
                    'model' => City::class,
                    'column' => 'name',
                    'method' => 'getSelectOption',
                ],
                'label' => [
                    'title' => 'city',
                ],
                'validation' => [
                    'rules' => [
                        'required',
                    ],
                ],
            ],
        ],
        'region_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Region::class,
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
                    ],
                ],
            ],
        ],
        'district_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => District::class,
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
                    ],
                ],
            ],
        ],
        'country_id' => [
            'type' => CollectionSelect::class,
            'options' => [
                'collection' => [
                    'model' => Country::class,
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
                    ],
                ],
            ],
        ],
    ];

    protected function adjustFieldsDefinition($fields)
    {
        // city
        $city = City::find($this->getInputFieldValue('city_id')) ?? $this->getModel()->city;

        $fields['city_id']['options']['attributes']['data-abs-ajax-url'] = $this->getController()->getRoute('repositoryAutocomplete', $this->getModel(), ['f' => 'city_id']);
        $fields['city_id']['options']['collection']['method'] = 'getSelectOption';
        $fields['city_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());

        if (is_null($city)) {
            $fields['region_id']['options']['collection'] = collect();
            $fields['district_id']['options']['collection'] = collect();
            $fields['country_id']['options']['collection'] = collect();
        } else {
            // region
            $fields['region_id']['options']['attributes']['title'] = null;
            $fields['region_id']['options']['collection'] = [
                'model' => Region::class,
                'column' => 'name',
                'filters' => [['class' => CityBelongsTo::class, 'data' => $city]]
            ];
            // district
            $fields['district_id']['options']['attributes']['title'] = null;
            $fields['district_id']['options']['collection'] = [
                'model' => District::class,
                'column' => 'name',
                'filters' => [['class' => CityBelongsTo::class, 'data' => $city]]
            ];
            // country
            $fields['country_id']['options']['attributes']['title'] = null;
            $fields['country_id']['options']['collection'] = [
                'model' => Country::class,
                'column' => 'name',
                'filters' => [['class' => CityBelongsTo::class, 'data' => $city]]
            ];
        }

        return $fields;
    }
}
