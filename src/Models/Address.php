<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasCadastralArea;
use Softworx\RocXolid\Common\Models\Traits\HasRegion;
use Softworx\RocXolid\Common\Models\Traits\HasDistrict;
use Softworx\RocXolid\Common\Models\Traits\HasCity;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

/**
 * Address model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Address extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;
    use HasCadastralArea;
    use HasRegion;
    use HasDistrict;
    use HasCity;

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'city',
        'country',
        'region',
        'district',
        'cadastralArea',
    ];

    /**
     * {@inheritDoc}
     */
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
        // 'latitude', // not truly decimal formattable
        // 'longitude', // not truly decimal formattable
    ];

    /**
     * Relation to parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function parent(): MorphTo
    {
        return $this->morphTo('model');
    }

    /**
     * {@inheritDoc}
     */
    public function resolvePolymorphUserModel(): string
    {
        return User::class;
    }

    /**
     * Format to a address label.
     *
     * @param bool $html
     * @param bool $with_name
     * @return string
     */
    public function getAddressLabel(bool $html = true, bool $with_name = false): string
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

    /**
     * {@inheritDoc}
     */
    public function fillCustom(Collection $data): Crudable
    {
        if (!is_null($this->latitude)) {
            $this->latitude = str_replace(',', '.', $this->latitude);
        }

        if (!is_null($this->longitude)) {
            $this->longitude = str_replace(',', '.', $this->longitude);
        }

        return parent::fillCustom($data);
    }

    /**
     * {@inheritDoc}
     */
    public function canBeDeleted(Request $request): bool
    {
        return false;
    }
}
