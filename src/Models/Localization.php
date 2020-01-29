<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// base models
use Softworx\RocXolid\Models\AbstractCrudModel;
// common models
use Softworx\RocXolid\Common\Models\Web;
// common traits
use Softworx\RocXolid\Common\Models\Traits\HasCountry;
use Softworx\RocXolid\Common\Models\Traits\HasLanguage;
use Softworx\RocXolid\Common\Models\Traits\HasLocale;

/**
 *
 */
class Localization extends AbstractCrudModel
{
    use SoftDeletes;
    use HasCountry;
    use HasLanguage;
    use HasLocale;

    public $is_label_with_flag = true;

    protected $fillable = [
        'name',
        'seo_url_slug',
        'country_id',
        'language_id',
        'locale_id'
    ];

    protected $relationships = [
        'webs',
        'country',
        'language',
        'locale',
    ];

    public function beforeSave($data, $action = null)
    {
        if ($this->seo_url_slug !== '/') { // homepage
            $this->seo_url_slug = collect(array_filter(explode('/', $this->seo_url_slug)))->map(function ($slug) {
                return Str::slug($slug);
            })->implode('/');
        }

        return $this;
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     */
    public function webs(): BelongsToMany
    {
        return $this->belongsToMany(Web::class, 'web_has_localizations');
    }
}
