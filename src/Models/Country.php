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
        if (isset($this->langauge_names[$language]) && isset($this->langauge_names[$language][$this->id]))
        {
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
}