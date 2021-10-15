<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts as rxContracts;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Group as UserGroup;
// rocXolid common models
use Softworx\RocXolid\Common\Models\WebFrontpageSettings;
use Softworx\RocXolid\Common\Models\Localization;


/**
 * Web model.
 * Represents a web instance runing on its own (sub)domain.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo revise
 */
class Web extends AbstractCrudModel implements rxContracts\HasTokenablePropertiesMethods
{
    use SoftDeletes;
    use rxTraits\HasTokenablePropertiesMethods;
    // @todo the trait's currently inactive - see comment in trait for more
    use Traits\UserGroupAssociated;

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'is_enabled',
        'name', // internal
        'title',
        'url',
        'domain',
        'email',
        'description',
        'user_group_id',
        'color',
        'is_label_with_name',
        'is_label_with_color',
        'is_label_with_flag',
        'default_localization_id',
        'is_use_default_localization_url_path',
        'is_error_exception_debug_mode',
        'error_not_found_message',
        'error_exception_message',
    ];

    /**
     * {@inheritDoc}
     */
    protected $relationships = [
        'userGroup',
        // 'frontpageSettings',
        'localizations',
        'defaultLocalization'
    ];

    /**
     * {@inheritDoc}
     */
    protected static $tokenable_properties = [
        'title',
        'domain',
    ];

    /**
     * {@inheritDoc}
     */
    public function onCreateBeforeSave(Collection $data): rxContracts\Crudable
    {
        $this
            ->createIfNeededUserGroup()
            ->createIfNeededFrontpageSettings();

        return $this;
    }

    /**
     * Create UserGroup if no assigned during creation process.
     *
     * @return \Softworx\RocXolid\Common\Models\Web
     */
    protected function createIfNeededUserGroup(): self
    {
        if (!$this->userGroup()->exists()) {
            $group = $this->userGroup()->getRelated()->create([
                'name' => $this->getTitle(),
            ]);

            $this->userGroup()->associate($group);
        }

        return $this;
    }

    /**
     * Create WebFrontpageSettings if no assigned during creation process.
     *
     * @return \Softworx\RocXolid\Common\Models\Web
     */
    protected function createIfNeededFrontpageSettings(): self
    {
        if (!$this->frontpageSettings()->exists()) {
            $this->frontpageSettings()->create([
                'name' => $this->getTitle(),
            ]);
        }

        return $this;
    }

    /**
     * Adjust the URL attribute by removing the trailing slash.
     *
     * @param  string  $value
     * @return void
     */
    public function setUrlAttribute($value)
    {
        $this->attributes['url'] = Str::endsWith($value, '/') ? Str::beforeLast($value, '/') : $value;
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     */
    public function userGroup(): Relations\BelongsTo
    {
        return $this->belongsTo(UserGroup::class);
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation
     */
    public function frontpageSettings(): Relations\HasOne
    {
        return $this->hasOne(WebFrontpageSettings::class);
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     */
    public function localizations(): Relations\BelongsToMany
    {
        return $this->belongsToMany(Localization::class, 'web_has_localizations');
    }

    /**
     * @Softworx\RocXolid\Annotations\AuthorizedRelation(policy_abilities="['assign']")
     */
    public function defaultLocalization(): Relations\BelongsTo
    {
        return $this->belongsTo(Localization::class);
    }

    /**
     * Obtain localized Web root URL.
     *
     * @param Softworx\RocXolid\Common\Models\Localization $localization
     * @return string
     */
    public function localizeUrl(Localization $localization): string
    {
        return (bool)$this->is_use_default_localization_url_path || !$localization->is($this->defaultLocalization)
            ? sprintf('%s/%s', $this->url, $localization->seo_url_slug)
            : $this->url;
    }

    public function pageUrl(Localization $localization, string $page_token): string
    {
        try {
            $page_id = config(sprintf('sitemap.%s.%s', $localization->language->iso_639_1, $page_token));

            return route(sprintf('frontpage.%s.page-%s', $this->domain, $page_id));
        } catch (RouteNotFoundException $e) {
            return '#';
        }
    }
}
