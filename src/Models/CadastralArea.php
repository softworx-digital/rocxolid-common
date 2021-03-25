<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;

/**
 * CadastralArea model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class CadastralArea extends AbstractCrudModel
{
    use SoftDeletes;
    use Traits\HasCity;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'code',
        'name',
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
