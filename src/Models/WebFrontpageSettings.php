<?php

namespace Softworx\RocXolid\Common\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
// rocxolid fundamentals
use Softworx\RocXolid\Models\AbstractCrudModel;
// rocXolid common models
use Softworx\RocXolid\Common\Models\File;
use Softworx\RocXolid\Common\Models\Image;
use Softworx\RocXolid\Common\Models\Web;

/**
 * WebFrontpageSettings model.
 * Stands for frontpage settings container assigned to a web instance.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 * @todo revise
 */
class WebFrontpageSettings extends AbstractCrudModel
{
    use SoftDeletes;
    use Traits\HasWeb;
    use Traits\HasImage;
    use Traits\UserGroupAssociatedWeb;

    protected $fillable = [
        'web_id',
        'name',
        // 'theme',
        // 'css',
        // 'js',
        // 'schema',
        'facebook_page_url',
        // 'facebook_app_id',
        // 'google_plus_page_url',
        // 'youtube_page_url',
        'google_analytics_tracking_code',
        'google_measurement_id',
        'google_tag_manager_container_id',
        // 'livechatoo_account',
        // 'livechatoo_language',
        // 'livechatoo_side',
        // 'dognet_account_id',
        // 'dognet_campaign_id',
        // 'twitter_card',
        // 'twitter_site',
        // 'twitter_creator',
    ];

    protected $relationships = [
        // 'web',
        //'cssFiles',
        //'jsFiles',
    ];

    protected $system = [
        'id',
        'css',
        'js',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
        // temporarily put here so they won't show up in details
        'schema',
        'facebook_app_id',
        'google_plus_page_url',
        'youtube_page_url',
        'livechatoo_account',
        'livechatoo_language',
        'livechatoo_side',
        'dognet_account_id',
        'dognet_campaign_id',
        'twitter_card',
        'twitter_site',
        'twitter_creator',
    ];

    protected $image_sizes = [
        'logo' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 180, 'height' => 55, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            //'fb' => [ 'width' => 474, 'height' => 145, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'mid' => [ 'width' => 512, 'height' => 512, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'default' => [ 'width' => 474, 'height' => 145, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
        'logoInverted' => [
            'thumb' => [ 'width' => 64, 'height' => 64, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'small' => [ 'width' => 300, 'height' => 74, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            'mid' => [ 'width' => 512, 'height' => 512, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
        ],
        'favicon' => [
            'mid' => [ 'width' => 512, 'height' => 512, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ], ],
            // apple-touch-icon
            '57x57' => [ 'width' => 57, 'height' => 57, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '60x60' => [ 'width' => 60, 'height' => 60, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '72x72' => [ 'width' => 72, 'height' => 72, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '76x76' => [ 'width' => 76, 'height' => 76, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '114x114' => [ 'width' => 114, 'height' => 114, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '120x120' => [ 'width' => 120, 'height' => 120, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '144x144' => [ 'width' => 144, 'height' => 144, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '152x152' => [ 'width' => 152, 'height' => 152, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '180x180' => [ 'width' => 180, 'height' => 180, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            // image/png
            '16x16' => [ 'width' => 16, 'height' => 16, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '32x32' => [ 'width' => 32, 'height' => 32, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '96x96' => [ 'width' => 96, 'height' => 96, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '192x192' => [ 'width' => 192, 'height' => 192, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            // msapplication
            '144x144' => [ 'width' => 144, 'height' => 144, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
            '192x192' => [ 'width' => 162, 'height' => 192, 'method' => 'resize', 'constraints' => [ 'aspectRatio', 'upsize', ] ],
        ],
    ];

    public function logo()
    {
        return $this->image('logo');
    }

    public function logoInverted()
    {
        return $this->image('logoInverted');
    }

    public function favicon()
    {
        return $this->image('favicon');
    }

    public function cssFiles()
    {
        return $this->morphMany(File::class, 'model')->where(sprintf('%s.model_attribute', (new File())->getTable()), 'cssFiles')->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }

    public function jsFiles()
    {
        return $this->morphMany(File::class, 'model')->where(sprintf('%s.model_attribute', (new File())->getTable()), 'jsFiles')->orderBy(sprintf('%s.model_attribute_position', (new File())->getTable()));
    }

    /**
     * {@inheritDoc}
     * @todo hotfixed
     */
    public function getShowAttributes(array $except = [], array $with = []): array
    {
        $except = [ 'theme', 'web', 'web_id', 'name' ];

        $attributes = $this->getAttributes();
        $attributes = array_diff_key($attributes, array_flip(array_merge($this->getSystemAttributes(), $this->getHidden())), array_flip($except)) + $with;


        return $attributes;
    }
}
