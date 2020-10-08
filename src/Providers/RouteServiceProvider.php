<?php

namespace Softworx\RocXolid\Common\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
// rocXolid services
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
            ->load($this->app->router)
            ->mapRouteModels($this->app->router);

        return $this;
    }

    /**
     * Define the routes for the package.
     *
     * @param \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function load(Router $router): IlluminateServiceProvider
    {
        $router->group([
            'module' => 'rocXolid-common',
            'middleware' => [ 'web', 'rocXolid.auth' ],
            'namespace' => 'Softworx\RocXolid\Common\Http\Controllers',
            'prefix' => sprintf('%s/common', config('rocXolid.admin.general.routes.root', 'rocXolid')),
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
            ], function ($router) {
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
            'prefix' => sprintf('%s/common', config('rocXolid.admin.general.routes.root', 'rocXolid')),
            'as' => 'rocXolid.common.',
        ], function ($router) {
            CrudRouterService::create('web', \Web\Controller::class);
            CrudRouterService::create('file', \File\Controller::class);
            CrudRouterService::create('image', \Image\Controller::class);
            CrudRouterService::create('country', \Country\Controller::class);
            CrudRouterService::create('region', \Region\Controller::class);
            CrudRouterService::create('district', \District\Controller::class);
            CrudRouterService::create('city', \City\Controller::class);
            CrudRouterService::create('cadastral-area', \CadastralArea\Controller::class);
            CrudRouterService::create('language', \Language\Controller::class);
            CrudRouterService::create('address', \Address\Controller::class);
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
                $router->get('/get/{file}', 'Controller@get')->name('get');
                $router->get('/download/{file}', 'Controller@download')->name('download');
                $router->post('/upload-complete', 'Controller@onUploadComplete')->name('upload-complete');
            });

            $router->group([
                'namespace' => 'Image',
                'prefix' => 'image',
                'as' => 'image.',
            ], function ($router) {
                $router->get('/get/{image}/{size?}', 'Controller@get')->name('get');
                $router->post('/upload-complete', 'Controller@onUploadComplete')->name('upload-complete');
            });

            $router->group([
                'namespace' => 'Address',
                'prefix' => 'address',
            ], function ($router) {
                $router->get('/show-map/{address}', 'Controller@showMap')->name('show-map');
            });
        });

        return $this;
    }

    /**
     * Define the route bindings for URL params.
     *
     * @param \Illuminate\Routing\Router $router Router to be used for routing.
     * @return \Illuminate\Support\ServiceProvider
     */
    private function mapRouteModels(Router $router): IlluminateServiceProvider
    {
        $router->model('web', \Softworx\RocXolid\Common\Models\Web::class);
        $router->model('file', \Softworx\RocXolid\Common\Models\File::class);
        $router->model('image', \Softworx\RocXolid\Common\Models\Image::class);
        $router->model('country', \Softworx\RocXolid\Common\Models\Country::class);
        $router->model('region', \Softworx\RocXolid\Common\Models\Region::class);
        $router->model('district', \Softworx\RocXolid\Common\Models\District::class);
        $router->model('city', \Softworx\RocXolid\Common\Models\City::class);
        $router->model('cadastral_area', \Softworx\RocXolid\Common\Models\CadastralArea::class);
        $router->model('language', \Softworx\RocXolid\Common\Models\Language::class);
        $router->model('address', \Softworx\RocXolid\Common\Models\Address::class);
        $router->model('locale', \Softworx\RocXolid\Common\Models\Locale::class);
        $router->model('localization', \Softworx\RocXolid\Common\Models\Localization::class);
        $router->model('nationality', \Softworx\RocXolid\Common\Models\Nationality::class);
        $router->model('name_day', \Softworx\RocXolid\Common\Models\NameDay::class);
        $router->model('attribute_group', \Softworx\RocXolid\Common\Models\AttributeGroup::class);
        $router->model('attribute', \Softworx\RocXolid\Common\Models\Attribute::class);
        $router->model('attribute_value', \Softworx\RocXolid\Common\Models\AttributeValue::class);

        return $this;
    }
}
