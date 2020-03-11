<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasCadastralArea;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;
use Softworx\RocXolid\Common\Models\Traits\HasDistrict;
use Softworx\RocXolid\Common\Models\Traits\HasCity;
// user management
use Softworx\RocXolid\UserManagement\Models\User;

class Address extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;
    use HasCadastralArea;
    use HasRegion;
    use HasDistrict;
    use HasCity;

    protected static $can_be_deleted = false;

    protected $fillable = [
        'name',
        'description',
        'country_id',
        'region_id',
        'district_id',
        'cadastral_area_id',
        'city_id',
        'city_name',
        'street_name',
        'street_no',
        'po_box',
        'zip',
        'latitude',
        'longitude',
    ];

    protected $relationships = [
        'city',
        'country',
        'region',
        'district',
        'cadastralArea',
    ];

    protected $system = [
        'id',
        'model_type',
        'city_name', // @todo: so far
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $decimals = [
        // 'latitude',
        // 'longitude',
    ];

    public function parent(): MorphTo
    {
        return $this->morphTo('model');
    }

    public function resolvePolymorphUserModel()
    {
        return User::class;
    }

    public function getAddressLabel($html = true, $with_name = false)
    {
        $label = sprintf(
            "%s %s\n%s %s\n%s%s%s",
            $this->street_name,
            $this->street_no,
            $this->zip,
            $this->city()->exists() ? $this->city->getTitle() : null,
            $this->region()->exists() ? $this->region->getTitle() . "\n" : null,
            $this->district()->exists() ? $this->district->getTitle() . "\n" : null,
            $this->country()->exists() ? $this->country->getTitle() : null
        );

        return $html ? nl2br($label) : $label;
    }

    public function fillCustom($data, $action = null)
    {
        if (!is_null($this->latitude)) {
            $this->latitude = str_replace(',', '.', $this->latitude);
        }

        if (!is_null($this->longitude)) {
            $this->longitude = str_replace(',', '.', $this->longitude);
        }

        return parent::fillCustom($data, $action);
    }
}
