<?php

namespace Softworx\RocXolid\Common\Models\Forms\Address;

// rocXolid forms & related
use Softworx\RocXolid\Forms\AbstractCrudForm as RocXolidAbstractCrudForm;
use Softworx\RocXolid\Forms\Fields\Type as FieldType;
// rocXolid common filters
use Softworx\RocXolid\Common\Filters;
// rocXolid common models
use Softworx\RocXolid\Common\Models;

class Create extends RocXolidAbstractCrudForm
{
    protected $options = [
        'method' => 'POST',
        'route-action' => 'store',
        'class' => 'form-horizontal form-label-left',
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
        'model_id' => [
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
        'zip' => [
            'type' => FieldType\Input::class,
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
                        'required_without:_data.city_name',
                        'exists:cities,id',
                    ],
                ],
            ],
        ],
        'city_name' => [
            'type' => FieldType\Input::class,
            'options' => [
                'label' => [
                    'title' => 'city',
                ],
                'validation' => [
                    'rules' => [
                        'required_without:_data.city_id',
                        'max:255',
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
    ];

    protected function adjustFieldsDefinition(array $fields): array
    {
        $fields['relation']['options']['value'] = $this->getInputFieldValue('relation');
        $fields['model_attribute']['options']['value'] = $this->getInputFieldValue('model_attribute');
        $fields['model_type']['options']['value'] = $this->getInputFieldValue('model_type');
        $fields['model_id']['options']['value'] = $this->getInputFieldValue('model_id');

        // country
        $country = Models\Country::find($this->getInputFieldValue('country_id')) ?? $this->getModel()->country;
        $country_input = Models\Country::find($this->getInputFieldValue('country_id'));
        $country_changed = $this->getModel()->country && $country_input && !$this->getModel()->country->is($country_input);
        //
        $fields['city_id']['options']['relation-filters'][] = [ 'type' => Filters\BelongsToCountry::class, 'data' => $country ];

        // @todo hotfixed
        if (request()->route()->getActionMethod() === 'formFieldAutocomplete') {
            return $fields;
        }

        $default_countries = collect(config('rocXolid.main.countries.default'));
        $other_countries = collect(config('rocXolid.main.countries.others'));

        $countries = Models\Country::whereIn('id', $default_countries->merge($other_countries))->orderBy('name')->get();

        $fields['country_id']['options']['collection'] = $countries->mapWithKeys(function (Models\Country $country) {
            return [ $country->getKey() => $country->getTitle() ];
        });
        $fields['country_id']['options']['attributes']['data-change-action'] = $this->getController()->getRoute('formReload', $this->getModel());
        //
        $city_countries = collect(config('rocXolid.main.countries.has_city_id'));
        $city_enabled = isset($country) && $city_countries->contains($country->getKey());

        $city = $city_enabled ? (Models\City::find($this->getInputFieldValue('city_id')) ?? $this->getModel()->city) : null;

        if (is_null($city) || !$city->country->is($country)) {
            $city = null;
        }

        $this
            ->adjustCityField($fields, $country, $city, $country_changed)
            ->adjustRegionField($fields, $country, $city, $country_changed)
            ->adjustDistrictField($fields, $country, $city, $country_changed);

        return $fields;
    }

    private function adjustCityField(&$fields, ?Models\Country $country, ?Models\City $city, bool $country_changed)
    {
        $countries = collect(config('rocXolid.main.countries.has_city_id'));
        $enabled = !is_null($country) && $countries->contains($country->getKey());

        if (!$enabled) {
            unset($fields['city_id']);
        } elseif (is_null($city)) {
            $fields['city_id']['options']['force-value'] = null;
        }

        $countries = collect(config('rocXolid.main.countries.has_not_city_name'));
        $enabled = isset($country) && !$countries->contains($country->getKey());

        if (!$enabled) {
            unset($fields['city_name']);
        }

        return $this;
    }

    private function adjustRegionField(&$fields, ?Models\Country $country, ?Models\City $city, bool $country_changed)
    {
        $countries = collect(config('rocXolid.main.countries.has_region_id'));
        $enabled = isset($country) && $countries->contains($country->getKey());

        if (!$enabled) {
            unset($fields['region_id']);
        } elseif ($city) {
            $fields['region_id']['options']['attributes']['title'] = null;
            $fields['region_id']['options']['collection']['filters'] = [[ 'class' => Filters\CityBelongsTo::class, 'data' => $city ]];
        } elseif ($country) {
            $fields['region_id']['options']['collection']['filters'] = [[ 'class' => Filters\BelongsToCountry::class, 'data' => $country ]];
        } else {
            throw new \RuntimeException('Undefined city or country');
        }

        return $this;
    }

    private function adjustDistrictField(&$fields, ?Models\Country $country, ?Models\City $city, bool $country_changed)
    {
        $countries = collect(config('rocXolid.main.countries.has_district_id'));
        $enabled = isset($country) && $countries->contains($country->getKey());

        if (!$enabled) {
            unset($fields['district_id']);
        } elseif ($city) {
            $fields['district_id']['options']['attributes']['title'] = null;
            $fields['district_id']['options']['collection']['filters'] = [[ 'class' => Filters\CityBelongsTo::class, 'data' => $city ]];
        } elseif ($country) {
            $fields['district_id']['options']['collection']['filters'] = [[ 'class' => Filters\BelongsToCountry::class, 'data' => $country ]];
        } else {
            throw new \RuntimeException('Undefined city or country');
        }

        return $this;
    }
}
