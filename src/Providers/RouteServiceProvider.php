<?php

namespace Softworx\Rocxolid\Common\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Softworx\RocXolid\Services\CrudRouterService;

/**
 * rocXolid routes service provider.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\Common
 * @version 1.0.0
 */
class RouteServiceProvider extends IlluminateServiceProvider
{
    /**
     * Bootstrap rocXolid routing services.
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
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\Common\Http\Controllers',
            'prefix' => sprintf('%s/common', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocXolid.common.',
        ], function ($router) {
            // package dashboard
            // $router->get('/', 'Controller@index')->name('dashboard');
            // ...

            $router->group([
                'namespace' => 'Attribute',
                'prefix' => 'attribute',
                'as' => 'attribute.',
            ], function ($router) {
                $router->get('/attribute/set-values/{attribute}', 'Controller@setValues')->name('setValues');
            });

            /*
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
            */
        });

        $router->group([
            'module' => 'rocXolid-common',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\Common\Http\Controllers',
            'prefix' => sprintf('%s/common', config('rocXolid.main.admin-path', 'rocXolid')),
            'as' => 'rocXolid.common.',
        ], function ($router) {
            CrudRouterService::create('web', \Web\Controller::class);
            CrudRouterService::create('file', \File\Controller::class);
            CrudRouterService::create('image', \Image\Controller::class);
            CrudRouterService::create('country', \Country\Controller::class);
            CrudRouterService::create('language', \Language\Controller::class);
            CrudRouterService::create('locale', \Locale\Controller::class);
            CrudRouterService::create('localization', \Localization\Controller::class);
            CrudRouterService::create('nationality', \Nationality\Controller::class);
            CrudRouterService::create('name-day', \NameDay\Controller::class);
            CrudRouterService::create('attribute-group', \AttributeGroup\Controller::class);
            CrudRouterService::create('attribute', \Attribute\Controller::class);
            CrudRouterService::create('attribute-value', \AttributeValue\Controller::class);

            $router->group([
                'namespace' => 'File',
                'prefix' => 'file',
                'as' => 'file.',
            ], function ($router) {
                $router->get('/file/{file}', 'Controller@get')->name('get');
            });

            $router->group([
                'namespace' => 'Image',
                'prefix' => 'image',
                'as' => 'image.',
            ], function ($router) {
                $router->get('/image/{image}/{dimension?}', 'Controller@get')->name('get');
            });
        });

        return $this;
    }
}
