<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Relations;
// rocXolid contracts
use Softworx\RocXolid\Forms\Contracts\Form;
use Softworx\RocXolid\Forms\Contracts\FormField;
// rocXolid common models
use Softworx\RocXolid\Common\Models\Web;

/**
 * Trait to assign model to the Web model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
trait HasWeb
{
    // @todo refactor
    private $_detected_web = null;

    /**
     * Web reference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function web(): Relations\BelongsTo
    {
        return $this->belongsTo(Web::class);
    }

    // @todo refactor
    public function detectWeb(Form $form)
    {
        if (is_null($this->_detected_web)) {
            $param = sprintf('%s.%s', FormField::SINGLE_DATA_PARAM, 'web_id');

            $id = $form->getRequest()->input($param, null);

            if (is_null($id) && ($input = $form->getInput())) {
                $id = Arr::get($input, $param, null);
            }

            if (is_null($id) && ($this->web()->exists())) {
                $this->_detected_web = $this->web;
            } else {
                $this->_detected_web = Web::findOrNew($id);
            }
        }

        return $this->_detected_web;
    }
}
