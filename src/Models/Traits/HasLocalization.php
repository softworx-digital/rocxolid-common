<?php

namespace Softworx\RocXolid\Common\Models\Traits;

use Illuminate\Support\Arr;
// rocXolid contracts
use Softworx\RocXolid\Forms\Contracts\Form;
use Softworx\RocXolid\Forms\Contracts\FormField;
// common models
use Softworx\RocXolid\Common\Models\Localization;

/**
 *
 */
trait HasLocalization
{
    private $_detected_localization = null;

    public function localization()
    {
        return $this->belongsTo(Localization::class);
    }

    public function detectLocalization(Form $form)
    {
        if (is_null($this->_detected_localization))
        {
            $param = sprintf('%s.%s', FormField::SINGLE_DATA_PARAM, 'localization_id');

            $id = $form->getRequest()->input($param, null);

            if (is_null($id) && ($input = $form->getInput()))
            {
                $id = Arr::get($input, $param, null);
            }

            if (is_null($id) && ($this->localization()->exists()))
            {
                $this->_detected_localization = $this->localization;
            }
            else
            {
                $this->_detected_localization = Localization::findOrNew($id);
            }
        }

        return $this->_detected_localization;
    }
}