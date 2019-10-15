<?php

namespace Softworx\RocXolid\Common\Http\Controllers;

use Softworx\RocXolid\Common\Components\Dashboard\Main as MainDashboard;

class Controller extends AbstractController
{
    public function index()
    {
        return (new MainDashboard($this))->render();
    }
}