<?php

namespace Softworx\RocXolid\Common\Http\Traits;

use Config;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Softworx\RocXolid\Common\Models\Web;

trait DetectsWeb
{
    private $_web = null;

    // @todo hotfixed
    public function detectOnlyWeb(Request $request)
    {
        return Web::where('domain', 'like', sprintf('%%%s', $request->getHost()))->firstOrFail();
    }

    public function detectWeb(Request $request = null)
    {
        if (is_null($this->_web)) {
            if (is_null($request)) {
                throw new \InvalidArgumentException('Request is required for first-time web detection');
            }

            try {
                $this->_web = Web::where('domain', 'like', sprintf('%%%s', $request->getHost()))->firstOrFail();
            } catch (ModelNotFoundException $e) {
                //dd(sprintf('--web pre domenu [%s] nie je definovany--> 404', $request->getHost()));
                throw new \RuntimeException(sprintf('Cannot detect web for [%s]', $request->getHost()));
            }

            if (!$this->_web->frontpageSettings()->exists()) {
                //dd(sprintf('--web [%s] nema priradene frontpage settings--> 500 (exception) ?', $this->_web->getKey()));
                throw new \RuntimeException(sprintf('Web [%s] has no frontpage settings attached', $this->_web->getTitle()));
            }
        }

        $paths = Config::get('view.paths');
        $resources = dirname(array_pop($paths));

        if (empty($this->_web->frontpageSettings->template_set)) {
            throw new \RuntimeException(sprintf('Web [%s] has no frontpage settings template set defined', $this->_web->getTitle()));
        }

        $template_set_directory = sprintf('%s/template-sets/%s', $resources, $this->_web->frontpageSettings->template_set);

        if (!is_dir($template_set_directory)) {
            throw new \RuntimeException(sprintf('Web [%s] has invalid frontpage settings template defined [%s] - directory does not exist', $this->_web->getTitle(), $template_set_directory));
        }

        View::addLocation($template_set_directory);

        return $this->_web;
    }
}
