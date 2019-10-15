<?php

namespace Softworx\Rocxolid\Common\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * RocXolid routes service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class RouteServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap RocXolid routing services.
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function boot()
    {
        $this
            ->load($this->app->router);

        return $this;
    }

    /**
     * Define the routes for the package.
     *
     * @param  \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(Router $router): IlluminateServiceProvider
    {
        $router->group([
            'module' => 'rocXolid-common',
            'middleware' => [ 'web', 'auth.rocXolid' ],
            'namespace' => 'Softworx\RocXolid\Common\Http\Controllers',
            'prefix' => sprintf('%s/common', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocxolid.common.',
        ], function ($router) {
            // package dashboard
            $router->get('/', 'Controller@index')->name('dashboard');
            // ...

            $router->group([
                'namespace' => 'Attribute',
                'prefix' => 'attribute',
            ], function ($router) {
                $router->get('/attribute/set-values/{attribute}', 'Controller@setValues');
            });

            $router->group([
                'namespace' => 'Translation',
                'prefix' => 'translation',
            ], function($router) {
                $router->get('{group?}', 'Controller@index')->where('group', '.*');
                $router->post('import', 'Controller@postImport');
                $router->post('find', 'Controller@postFind');

                $router->group([
                    'prefix' => 'group',
                ], function ($router) {
                    $router->post('publish/{group}', 'Controller@postPublish')->where('group', '.*');
                    $router->post('add/{group}', 'Controller@postAdd')->where('group', '.*');
                    $router->post('edit/{group}', 'Controller@postEdit')->where('group', '.*');
                    $router->post('delete/{group}/{key}', 'Controller@postDelete')->where('group', '.*');
                });
            });
        });

        $router->group([
            'module' => 'rocXolid-common',
            'middleware' => [ 'web', 'auth.rocXolid' ],
            'namespace' => '',
            'prefix' => sprintf('%s/common', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocxolid.common.',
        ], function ($router) {
            CrudRouter::create('web', Http\Controllers\Web\Controller::class);
            CrudRouter::create('file', Http\Controllers\File\Controller::class);
            CrudRouter::create('image', Http\Controllers\Image\Controller::class);
            CrudRouter::create('country', Http\Controllers\Country\Controller::class);
            CrudRouter::create('language', Http\Controllers\Language\Controller::class);
            CrudRouter::create('locale', Http\Controllers\Locale\Controller::class);
            CrudRouter::create('localization', Http\Controllers\Localization\Controller::class);
            CrudRouter::create('name-day', Http\Controllers\NameDay\Controller::class);
            CrudRouter::create('attribute-group', Http\Controllers\AttributeGroup\Controller::class);
            CrudRouter::create('attribute', Http\Controllers\Attribute\Controller::class);
            CrudRouter::create('attribute-value', Http\Controllers\AttributeValue\Controller::class);

            $router->group([
                'namespace' => 'Softworx\RocXolid\Common\Http\Controllers\File',
                'prefix' => 'file',
            ], function ($router) {
                $router->get('/file/{file}', 'Controller@get');
            });

            $router->group([
                'namespace' => 'Softworx\RocXolid\Common\Http\Controllers\Image',
                'prefix' => 'image',
            ], function ($router) {
                $router->get('/image/{image}/{dimension?}', 'Controller@get');
            });
        });

        return $this;
    }
}
