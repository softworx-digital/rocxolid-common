<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

/**
 * Address model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo revise
 */
class Address extends AbstractCrudModel
{
    use SoftDeletes;
    use Traits\HasCountry;
    use Traits\HasCadastralArea;
    use Traits\HasRegion;
    use Traits\HasDistrict;
    use Traits\HasCity;

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
        'model_id',
        'model_attribute',
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
     * {@inheritDoc}
     */
    public function getTitle(): string
    {
        return $this->name ?: $this->getAddressLabel(false, true, false);
    }

    /**
     * Relation to parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function parent(): MorphTo
    {
        return $this->morphTo('model');
    }

    public function scopeIsWithinRadius(Builder $query, float $lat, float $lon, float $radius)
    {
        $haversine = sprintf('(6371000 * acos(cos(radians(?)) * cos(radians(%s)) * cos(radians(%s) - radians(?)) + sin(radians(?)) * sin(radians(%s))))', [
            $this->qualifyColumn('latitude'),
            $this->qualifyColumn('longitude'),
            $this->qualifyColumn('latitude'),
        ]);

        return $query
           ->selectRaw("{$haversine} AS distance", [
                $lat,
                $lon,
                $lat,
           ])
           ->having('distance', '<', $radius);
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
    public function getAddressLabel(bool $html = true, bool $inline = false, bool $full = true): string
    {
        $separator = $inline ? ', ' : "\n";

        if (filled($this->street_name) && filled($this->street_no)) {
            $identification = sprintf('%s %s%s', $this->street_name, $this->street_no, $separator);
        } elseif (filled($this->street_no)) {
            $identification = $full ? '' : sprintf('%s ', $this->street_no);
        } elseif ($this->city()->exists() && method_exists($this->parent, 'getAddressCityIdentifier')) {
            $identification = sprintf('%s %s', $this->city->getTitle(), $this->parent->getAddressCityIdentifier());
        } elseif (method_exists($this->parent, 'getAddressIdentifier')) {
            $identification = $this->parent->getAddressIdentifier();
        } else {
            $identification = null;
        }

        if (method_exists($this->parent, 'getAddressQualifier')) {
            $qualification = $this->parent->getAddressQualifier();
        } else {
            $qualification = null;
        }

        if ($full) {
            $label = sprintf(
                "%s%s%s %s{$separator}%s%s%s",
                $identification ? $identification : null,
                $qualification ? $qualification . $separator : null,
                $this->zip,
                ($this->city()->exists() ? $this->city->getTitle() : (filled($this->city_name) ? $this->city_name : null)) . (blank($this->street_name) && filled($this->street_no) ? sprintf(' %s', $this->street_no) : ''),
                $this->region()->exists() ? $this->region->getTitle() . $separator : null,
                $this->district()->exists() ? $this->district->getTitle() . $separator : null,
                $this->country()->exists() ? $this->country->getTitle() : null
            );
        } else {
            $label = sprintf(
                "%s%s %s %s, %s",
                $identification ? $identification : null,
                $qualification ? $qualification . $separator : null,
                $this->city()->exists() ? $this->city->getTitle() : (filled($this->city_name) ? $this->city_name : null),
                $this->zip,
                $this->country()->exists() ? $this->country->getTitle() : null
            );
        }

        return $html ? nl2br($label) : $label;
    }

    /**
     * Format to a inline address label.
     *
     * @return string
     */
    public function getInlineAddressLabel(): string
    {
        return $this->getAddressLabel(false, true);
    }

    /**
     * Format to a brief inline address label.
     *
     * @return string
     */
    public function getBriefInlineAddressLabel(): string
    {
        return $this->getAddressLabel(false, true, false);
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

        if (!$data->has('city_id')) {
            $this->city_id = null;
        }

        if (!$data->has('city_name')) {
            $this->city_name = null;
        }

        if (!$data->has('region_id')) {
            $this->region_id = null;
        }

        if (!$data->has('district_id')) {
            $this->district_id = null;
        }

        if (!$data->has('cadastral_area_id')) {
            $this->cadastral_area_id = null;
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

    /**
     * {@inheritDoc}
     * @todo ugly
     */
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        $this->model_attribute = $data->get('model_attribute');

        return parent::onCreateBeforeSave($data);
    }
}
