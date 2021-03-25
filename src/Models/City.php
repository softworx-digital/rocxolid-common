<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;

/**
 * City model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class City extends AbstractCrudModel
{
    use SoftDeletes;
    use Traits\HasCountry;
    use Traits\HasRegion;
    use Traits\HasDistrict;
    use Traits\HasCadastralAreas;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'type',
        'code',
        'name',
        'zip',
        'description',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
    ];

    /**
     * {@inheritDoc}
     */
    protected $enums = [
        'type',
    ];

    /**
     * {@inheritDoc}
     */
    protected $search_columns = [
        'name',
    ];

    /**
     * {@inheritDoc}
     */
    public function toSearchResult(?string $param = null): array
    {
        return [
            'value' => $this->getKey(),
            'text' => $this->getTitle(),
            'data' => $this->district()->exists() ? [
                'subtext' => $this->district->getTitle(),
            ] : null
        ];
    }
}
