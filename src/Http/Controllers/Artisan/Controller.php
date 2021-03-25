<?php

namespace Softworx\RocXolid\Common\Http\Controllers\Artisan;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Collection;
// rocXolid utils
use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid contracts
use Softworx\RocXolid\Contracts\Repositoryable;
use Softworx\RocXolid\Contracts\Modellable;
use Softworx\RocXolid\Http\Controllers\Contracts\Dashboardable;
use Softworx\RocXolid\Repositories\Contracts\Repository;
use Softworx\RocXolid\Models\Contracts\Sortable;
// rocXolid traits
use Softworx\RocXolid\Traits as rxTraits;
use Softworx\RocXolid\Http\Controllers\Traits as rxControllerTraits;
// rocXolid cms controllers
use Softworx\RocXolid\Common\Http\Controllers\AbstractController;
// rocXolid cms components
use Softworx\RocXolid\Common\Components\Dashboard\ArtisanTerminal as ArtisanTerminalDashboard;

/**
 * Controller to handle Artisan Commands.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 * @todo quick'n'dirty
 */
class Controller extends AbstractController implements Repositoryable, Modellable, Dashboardable
{
    use rxTraits\Repositoryable;
    use rxTraits\Modellable;
    use rxControllerTraits\Dashboardable;
    use rxControllerTraits\Components\ModelViewerComponentable;

    protected static $dashboard_type = ArtisanTerminalDashboard::class;

    /**
     * {@inheritDoc}
     */
    protected $default_services = [
    ];

    /**
     * Model type to work with.
     *
     * @var string
     */
    // protected static $model_type = DocumentType::class;

    /**
     * Constructor.
     *
     * @param \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse $response
     */
    public function __construct(AjaxResponse $response)
    {
        // @todo !!! find some way to pass attribute to CrudPolicy::before() check
        // causes problems this way
        // $this->authorizeResource(static::getModelType(), static::getModelType()::getAuthorizationParameter());

        $this
            ->setResponse($response)
            ->bindServices()
            ->init();
    }

    /**
     * Display options to generate various documents.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     */
    public function index(CrudRequest $request)
    {
        $assignments = collect([
            'controller' => $this,
        ]);

        return $this
            ->getDashboard()
            ->render('default', [ 'assignments' => $assignments ]);
    }

    /**
     * Save the position of documents and document types.
     *
     * @param \Softworx\RocXolid\Http\Requests\CrudRequest $request
     * @todo quite ugly & put it some general trait
     */
    public function run(CrudRequest $request)
    {
        if ($request->has('type')) {
            $options = [];
            if ($request->has('dry-run')) {
                $options['--dry-run'] = true ;
            }
            if ($request->has('verbose')) {
                $options['--verbose'] = true ;
            }

            $command = app($request->input('type'));

            $return_code = Artisan::call($command->getName(), $options);
            $output = Artisan::output();

            $dashboard = $this->getDashboard();

            if ($return_code) {
                return $this->response
                    ->notifyError('Error occured, see logs for more info')
                    ->get();
            } else {
                return $this->response
                    ->notifySuccess('Finished')
                    ->replace($dashboard->getDomId('output'), $dashboard->fetch('include.output', ['assignments' => collect([
                        'controller' => $this,
                        'output' => $output,
                    ])]))
                    ->get();
            }
        }

        return $this->response
            ->notifyError($this->translate('text.missing-type'))
            ->get();
    }

    public function availableCommands(): Collection
    {
        return collect(config('rocXolid.common.artisan.commands'))->transform(function (string $type) {
            return app($type);
        });
    }
}
