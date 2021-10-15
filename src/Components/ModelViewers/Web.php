<?php

namespace Softworx\RocXolid\Common\Components\ModelViewers;

// rocXolid common components
use Softworx\RocXolid\Common\Components\ModelViewers\AbstractTabbedCrudModelViewer;

/**
 * Model viewer for Web model.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class Web extends AbstractTabbedCrudModelViewer
{
    /**
     * @inheritDoc
     */
    protected $tabs = [
        'default',
        'frontpage-settings',
        'error-settings',
    ];

    /**
     * @inheritDoc
     */
    protected $panels = [
        'data' => [
            'general' => [
                'name', // internal
                'title',
                'url',
                'domain',
                'email',
            ],
            'description' => [
                'description',
            ],
            'localization' => [
                'localizations',
                'default_localization_id',
                'is_use_default_localization_url_path',
            ],
            'label' => [
                'color',
                'is_label_with_name',
                'is_label_with_color',
                'is_label_with_flag',
            ],
            'error-not-found' => [
                'error_not_found_message',
            ],
            'error-exception' => [
                'is_error_exception_debug_mode',
                'error_exception_message',
            ],
        ],
    ];
}
