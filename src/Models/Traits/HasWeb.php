<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Arr;
// rocXolid contracts
use Softworx\RocXolid\Forms\Contracts\Form;
use Softworx\RocXolid\Forms\Contracts\FormField;
// common models
use Softworx\RocXolid\Common\Models\Web;

/**
 *
 */
trait HasWeb
{
    private $_detected_web = null;

    public function web()
    {
        return $this->belongsTo(Web::class);
    }

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
