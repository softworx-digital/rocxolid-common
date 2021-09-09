<?php

namespace Softworx\RocXolid\Common\Http\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
 */
trait DetectsLocalization
{
    private $_localization = null;

    public function detectLocalization(Web $web, &$path)
    {
        if (is_null($this->_localization)) {
            list($localization_slug, $path) = array_pad(explode('/', $path, 2), 2, '/');

            try {
                $this->_localization = Localization::whereHas('webs', function ($query) use ($web, $localization_slug) {
                    $query
                        ->where('web_id', $web->getKey())
                        ->where('seo_url_slug', '=', $localization_slug);
                })->firstOrFail();
            } catch (ModelNotFoundException $e) {
                throw new \RuntimeException(sprintf('Cannot detect localization for [%s] and web [%s]', $localization_slug, $web->getTitle()));
            }
        }

        return $this->_localization;
    }
}
