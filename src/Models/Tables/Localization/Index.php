<?php

namespace Softworx\RocXolid\Common\Models\Tables\Localization;

use Softworx\RocXolid\Tables\AbstractCrudTable;
// filters
use Softworx\RocXolid\Tables\Filters\Type\Text as TextFilter;
use Softworx\RocXolid\Tables\Filters\Type\Select as SelectFilter;
use Softworx\RocXolid\Tables\Filters\Type\ModelRelation as ModelRelationFilter;
use Softworx\RocXolid\Tables\Columns\Type\Text;
use Softworx\RocXolid\Tables\Columns\Type\ModelRelation;
// models
use Softworx\RocXolid\Common\Models\Web;
use Softworx\RocXolid\Common\Models\Country;
use Softworx\RocXolid\Common\Models\Language;
use Softworx\RocXolid\Common\Models\Locale;

/**
 *
 */
class Index extends AbstractCrudTable
{
    protected $filters = [
        'name' => [
            'type' => TextFilter::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
                'attributes' => [
                    'placeholder' => 'name'
                ],
            ],
        ],/*
        'webs' => [
            'type' => ModelRelationFilter::class,
            'options' => [
                'label' => [
                    'title' => 'webs'
                ],
                'collection' => [
                    'model' => Web::class,
                    'column' => 'name',
                ],
            ],
        ],*/
        'seo_url_slug' => [
            'type' => TextFilter::class,
            'options' => [
                'label' => [
                    'title' => 'seo_url_slug'
                ],
                'attributes' => [
                    'placeholder' => 'seo_url_slug'
                ],
            ],
        ],
        'country_id' => [
            'type' => ModelRelationFilter::class,
            'options' => [
                'label' => [
                    'title' => 'country'
                ],
                'collection' => [
                    'model' => Country::class,
                    'column' => 'name',
                ],
            ],
        ],
        'language_id' => [
            'type' => ModelRelationFilter::class,
            'options' => [
                'label' => [
                    'title' => 'language'
                ],
                'collection' => [
                    'model' => Language::class,
                    'column' => 'name',
                ],
            ],
        ],
        'locale_id' => [
            'type' => ModelRelationFilter::class,
            'options' => [
                'label' => [
                    'title' => 'locale'
                ],
                'collection' => [
                    'model' => Locale::class,
                    'column' => 'name',
                ],
            ],
        ],
    ];

    protected $columns = [
        'name' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'name'
                ],
            ],
        ],
        'webs' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'webs'
                ],
                'relation' => [
                    'name' => 'webs',
                    'column' => 'name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'seo_url_slug' => [
            'type' => Text::class,
            'options' => [
                'label' => [
                    'title' => 'seo_url_slug'
                ],
            ],
        ],
        'country_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'country_id'
                ],
                'relation' => [
                    'name' => 'country',
                    'column' => 'name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'language_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'language_id'
                ],
                'relation' => [
                    'name' => 'language',
                    'column' => 'name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
        'locale_id' => [
            'type' => ModelRelation::class,
            'options' => [
                'ajax' => true,
                'label' => [
                    'title' => 'locale_id'
                ],
                'relation' => [
                    'name' => 'locale',
                    'column' => 'name',
                ],
                'wrapper' => [
                    'attributes' => [
                        'class' => 'text-center',
                    ],
                ],
            ],
        ],
    ];
}
