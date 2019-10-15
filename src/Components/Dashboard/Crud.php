<?php

namespace Softworx\RocXolid\Common\Components\Dashboard;

use Softworx\RocXolid\Common\Components\AbstractActiveComponent;
use Softworx\RocXolid\Components\Contracts\Repositoryable;
use Softworx\RocXolid\Components\Contracts\RepositoryComponentable;
use Softworx\RocXolid\Components\Contracts\Modellable;
use Softworx\RocXolid\Components\Contracts\ModelViewerComponentable;
use Softworx\RocXolid\Components\ModelViewers\CrudModelViewer;

// @todo - schovat metody zrejme do traitu, nech sa nemusia stale opakovat v roznych packageoch - rozdiel napr oproti generickemu je, ze dedi od ineho, kvoli templatom
class Crud extends AbstractActiveComponent implements RepositoryComponentable, ModelViewerComponentable
{
    protected $repository_component = null;

    protected $model_viewer_component = null;

    public function setRepositoryComponent(Repositoryable $component): RepositoryComponentable
    {
        $this->repository_component = $component;

        return $this;
    }

    public function getRepositoryComponent(): Repositoryable
    {
        if (is_null($this->repository_component))
        {
            throw new \RuntimeException(sprintf('CRUD table / repository_component not yet set to [%s]', get_class($this)));
        }

        return $this->repository_component;
    }

    public function setModelViewerComponent(CrudModelViewer $model_viewer_component): ModelViewerComponentable
    {
        $this->model_viewer_component = $model_viewer_component;

        return $this;
    }

    public function getModelViewerComponent(): CrudModelViewer
    {
        if (is_null($this->model_viewer_component))
        {
            throw new \RuntimeException(sprintf('CRUD model_viewer_component not yet set to [%s]', get_class($this)));
        }

        return $this->model_viewer_component;
    }
}