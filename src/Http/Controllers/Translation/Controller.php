<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Translation;

use Auth;
use Illuminate\Http\Request;
use Softworx\RocXolid\Common\Http\Controllers\AbstractCrudController;
use Softworx\RocXolid\Traits\Routable as RoutableTrait;
use Softworx\RocXolid\Common\Models\NameDay;
use Softworx\RocXolid\Common\Components\Dashboard\Main as MainDashboard;

class Controller extends \Barryvdh\TranslationManager\Controller
{
    use RoutableTrait;

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
