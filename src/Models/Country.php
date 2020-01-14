<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Region;
use Softworx\RocXolid\Common\Models\City;

class Country extends AbstractCrudModel
{
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'capital',
        'citizenship',
        //'country_code',
        'currency',
        'currency_code',
        'currency_sub_unit',
        'currency_symbol',
        'currency_iso_4217',
        //'currency_decimals',
        //'currency_decimal_separator',
        //'currency_thousand_separator',
        'full_name',
        'iso_3166_2',
        'iso_3166_3',
        'name',
        //'region_code',
        //'sub_region_code',
        //'eea',
        'calling_code',
        //'flag',
        'is_address_label_use_address',
        'is_address_label_use_address_detail',
        'is_address_label_use_postal_code',
        'is_address_label_use_city',
        'is_address_label_use_region',
        'is_address_label_use_country',
    ];

    protected $relationships = [
    ];

    protected $langauge_names = [
        'sk' => [
            58 => 'Česká republika',
            203 => 'Slovenská republika',
        ],
        'cs' => [
            58 => 'Česká republika',
            203 => 'Slovenská republika',
        ],
    ];

    public function getLanguageName($language = 'sk')
    {
        if (isset($this->langauge_names[$language]) && isset($this->langauge_names[$language][$this->id])) {
            return $this->langauge_names[$language][$this->id];
        }

        return $this->getTitle();
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function isPrimary()
    {
        return collect(config('rocXolid.main.countries.default'))->contains($this->id);
    }

    public function isSecondary()
    {
        return collect(config('rocXolid.main.countries.others'))->contains($this->id);
    }

    public function hasBirthNumber()
    {
        return collect(config('rocXolid.main.countries.has_birth_no'))->contains($this->id);
    }

    public function hasIDCardNumber()
    {
        return collect(config('rocXolid.main.countries.has_id_card_no'))->contains($this->id);
    }

    public function hasPassportNumber()
    {
        return !collect(config('rocXolid.main.countries.has_not_passport_no'))->contains($this->id);
    }

    public function hasCompanyRegistrationNumber()
    {
        return collect(config('rocXolid.main.countries.has_company_registration_no'))->contains($this->id);
    }

    public function hasCompanyInsertionNumber()
    {
        return collect(config('rocXolid.main.countries.has_company_insertion_no'))->contains($this->id);
    }

    public function hasTaxNumber()
    {
        return collect(config('rocXolid.main.countries.has_tax_no'))->contains($this->id);
    }

    public function hasRegions()
    {
        return collect(config('rocXolid.main.countries.has_region_id'))->contains($this->id);
    }

    public function hasDistricts()
    {
        return collect(config('rocXolid.main.countries.has_district_id'))->contains($this->id);
    }

    public function hasCities()
    {
        return collect(config('rocXolid.main.countries.has_city_id'))->contains($this->id);
    }

    public function hasCityName()
    {
        return !collect(config('rocXolid.main.countries.has_not_city_name'))->contains($this->id);
    }
}
