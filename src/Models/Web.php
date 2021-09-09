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
use Softworx\RocXolid\Models\Traits\Attributes as AttributeTraits;
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
    use AttributeTraits\HasGeneralDataAttributes;
    use AttributeTraits\HasLocalizationDataAttributes;
    use AttributeTraits\HasLabelDataAttributes;
    use AttributeTraits\HasDescriptionDataAttributes;
    // @todo the trait's currently inactive - see comment in trait for more
    use Traits\UserGroupAssociated;

    protected const GENERAL_DATA_ATTRIBUTES = [
        'name', // internal
        'title',
        'url',
        'domain',
        'email',
    ];

    protected const LOCALIZATION_DATA_ATTRIBUTES = [
        'localizations',
        'defaultLocalization',
        'is_use_default_localization_url_path',
    ];

    protected const LABEL_DATA_ATTRIBUTES = [
        'color',
        'is_label_with_name',
        'is_label_with_color',
        'is_label_with_flag',
    ];

    protected const DESCRIPTION_DATA_ATTRIBUTES = [
        'description',
    ];

    protected const ERROR_NOT_FOUND_DATA_ATTRIBUTES = [
        'error_not_found_message',
    ];

    protected const ERROR_EXCEPTION_DATA_ATTRIBUTES = [
        'is_error_exception_debug_mode',
        'error_exception_message',
    ];

    protected static $tokenable_properties = [
        'title',
        'domain',
    ];

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
    public function onCreateBeforeSave(Collection $data): rxContracts\Crudable
    {
        $this
            ->createIfNeededUserGroup()
            ->createIfNeededFrontpageSettings()
            ->stripTrailingSlash();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function onUpdateBeforeSave(Collection $data): rxContracts\Crudable
    {
        $this->stripTrailingSlash();

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

    /**
     * Retrieve "not found" error data attributes.
     *
     * @param bool $keys Flag to retrieve only attribute keys.
     * @return Illuminate\Support\Collection
     */
    public function getErrorNotFoundDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::ERROR_NOT_FOUND_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::ERROR_NOT_FOUND_DATA_ATTRIBUTES)->sortBy(function ($value, string $field) {
                return array_search($field, static::ERROR_NOT_FOUND_DATA_ATTRIBUTES);
            });
    }

    /**
     * Retrieve "exception" error data attributes.
     *
     * @param bool $keys Flag to retrieve only attribute keys.
     * @return Illuminate\Support\Collection
     */
    public function getErrorExceptionDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::ERROR_EXCEPTION_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::ERROR_EXCEPTION_DATA_ATTRIBUTES)->sortBy(function ($value, string $field) {
                return array_search($field, static::ERROR_EXCEPTION_DATA_ATTRIBUTES);
            });
    }

    /**
     * Remove trailing slash from the URL.
     *
     * @return \Softworx\RocXolid\Common\Models\Web
     */
    protected function stripTrailingSlash(): self
    {
        if (Str::endsWith($this->url, '/')) {
            $this->url = Str::beforeLast($this->url, '/');
        }

        return $this;
    }
}
