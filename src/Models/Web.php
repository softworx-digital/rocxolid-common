<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
//
use Softworx\RocXolid\Models\AbstractCrudModel;
// traits
use Softworx\RocXolid\Models\Traits\GetsRelationships;
// common traits
use Softworx\RocXolid\Common\Models\Traits\UserGroupAssociated;
// cms models
use Softworx\RocXolid\CMS\Models\WebFrontpageSettings;
// user management models
use Softworx\RocXolid\UserManagement\Models\Group as UserGroup;
/**
 *
 */
class Web extends AbstractCrudModel
{
    use SoftDeletes;
    use GetsRelationships;
    use UserGroupAssociated;

    protected $guarded = [
        'id'
    ];

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
        //'is_label_with_flag',
        'default_localization_id',
    ];

    protected $relationships = [
        'userGroup',
        'frontpageSettings',
        'localizations',
        'defaultLocalization'
    ];

    public function afterSave($data, $action = null)
    {
        $this
            ->createIfNeededUserGroup()
            ->createIfNeededFrontpageSettings();

        return $this;
    }

    protected function createIfNeededUserGroup()
    {
        if (!$this->userGroup()->exists())
        {
            $group = UserGroup::create([
                'name' => $this->getTitle(),
            ]);

            $this->userGroup()->associate($group);
            $this->save();
        }

        return $this;
    }

    protected function createIfNeededFrontpageSettings()
    {
        if (!$this->frontpageSettings()->exists())
        {
            $frontpage_settings = WebFrontpageSettings::make([
                'name' => $this->getTitle(),
                'template_set' => 'default',
                //'livechatoo_language' => $this->language->iso_639_1,
            ]);

            $frontpage_settings->web()->associate($this);
            $frontpage_settings->save();
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