<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;
use Softworx\RocXolid\Common\Models\Traits\HasDistrict;
use Softworx\RocXolid\Common\Models\Traits\HasCity;
// user management
use Softworx\RocXolid\UserManagement\Models\User;

class Address extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;
    use HasRegion;
    use HasDistrict;
    use HasCity;

    protected static $can_be_deleted = false;

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'name',
        'description',
        'country_id',
        'region_id',
        'district_id',
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
    ];

    public function parent()
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

    protected function allowPermissionException(Authenticatable $user, string $method_group, string $permission)
    {
        if (!$this->exists) {
            return true;
        }

        return !$this->exists || $this->parent->is($user);
    }
}
