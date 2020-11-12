<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\Group as UserGroup;
//  rocXolid common model traits
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociated;
// rocXolid cms models
use Softworx\RocXolid\CMS\Models\WebFrontpageSettings;

/**
 *
 */
class Web extends AbstractCrudModel
{
    use SoftDeletes;
    use UserGroupAssociated;

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
    ];

    protected $relationships = [
        'userGroup',
        'frontpageSettings',
        'localizations',
        'defaultLocalization'
    ];

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
}
