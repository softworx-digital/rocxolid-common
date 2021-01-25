<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
use Softworx\RocXolid\Models\Traits\Attributes as AttributeTraits;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Group as UserGroup;
// rocXolid cms models
use Softworx\RocXolid\Common\Models\WebFrontpageSettings;

/**
 * Web model.
 * Represents a web instance runing on its own (sub)domain.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo revise
 */
class Web extends AbstractCrudModel
{
    use SoftDeletes;
    use AttributeTraits\HasGeneralDataAttributes;
    use AttributeTraits\HasLocalizationDataAttributes;
    use AttributeTraits\HasLabelDataAttributes;
    use AttributeTraits\HasDescriptionDataAttributes;
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
        'defaultLocalization'
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
        'is_error_exception_debug',
        'error_exception_message',
    ];

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
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
        'is_error_exception_debug',
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
    public function onCreateBeforeSave(Collection $data): Crudable
    {
        // dd(__METHOD__, '@todo');
        $this
            ->createIfNeededUserGroup()
            ->createIfNeededFrontpageSettings();

        return $this;
    }

    protected function createIfNeededUserGroup()
    {
        if (!$this->userGroup()->exists()) {
            $group = $this->userGroup()->getRelated()->create([
                'name' => $this->getTitle(),
            ]);//->associate($this); //->save()

            $this->userGroup()->associate($group);
        }

        return $this;
    }

    protected function createIfNeededFrontpageSettings()
    {
        if (!$this->frontpageSettings()->exists()) {
            $this->frontpageSettings()->create([
                'name' => $this->getTitle(),
            ]);
        }

        return $this;
    }

    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class);
    }

    public function frontpageSettings()
    {
        return $this->hasOne(WebFrontpageSettings::class);
    }

    public function localizations()
    {
        return $this->belongsToMany(Localization::class, 'web_has_localizations');
    }

    public function defaultLocalization()
    {
        return $this->belongsTo(Localization::class);
    }

    /**
     * Retrieve "not found" error data attributes.
     *
     * @param boolean $keys Flag to retrieve only attribute keys.
     * @return Collection
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
     * @param boolean $keys Flag to retrieve only attribute keys.
     * @return Collection
     */
    public function getErrorExceptionDataAttributes(bool $keys = false): Collection
    {
        return $keys
            ? collect(static::ERROR_EXCEPTION_DATA_ATTRIBUTES)
            : collect($this->getAttributes())->only(static::ERROR_EXCEPTION_DATA_ATTRIBUTES)->sortBy(function ($value, string $field) {
                return array_search($field, static::ERROR_EXCEPTION_DATA_ATTRIBUTES);
            });
    }
}
