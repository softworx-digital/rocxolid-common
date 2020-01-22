<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Translation;

use Auth;
use Illuminate\Http\Request;
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Traits\Routable as RoutableTrait;
use Softworx\RocXolid\Common\Models\NameDay;
use Softworx\RocXolid\Common\Repositories\NameDay\Repository;
use Softworx\RocXolid\Common\Components\Dashboard\Main as MainDashboard;

class Controller extends \Barryvdh\TranslationManager\Controller
{
    use RoutableTrait;

    public function userCan($policy_ability_group)
    {
        dd(__METHOD__);
        $permission = sprintf('\%s.%s', get_class($this), $policy_ability_group);

        if ($user = Auth::guard('rocXolid')->user()) {
            if ($user->id == 1) {
                return true;
            }

            foreach ($user->permissions as $extra_permission) {
                if (($extra_permission->controller_class == sprintf('\%s', static::class)) && ($extra_permission->policy_ability_group == $policy_ability_group)) {
                    return true;
                } elseif (($policy_ability_group == 'read-only') && (($extra_permission->controller_class == sprintf('\%s', static::class)) && ($extra_permission->policy_ability_group == 'write'))) {
                    return true;
                }
            }

            foreach ($user->roles as $role) {
                foreach ($role->permissions as $permission) {
                    if (($permission->controller_class == sprintf('\%s', static::class)) && ($permission->policy_ability_group == $policy_ability_group)) {
                        return true;
                    } elseif (($policy_ability_group == 'read-only') && (($permission->controller_class == sprintf('\%s', static::class)) && ($permission->policy_ability_group == 'write'))) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function index(Request $request, $group = null)
    {
        return $this->getIndex($request->get('group', $group));
    }

    public function getIndex($group = null)
    {
        $view = parent::getIndex($group);
        $view->with('translation_controller', $this);

        return (new MainDashboard($this))->render('translation', [
            'translation_view' => $view,
        ]);
    }
}
