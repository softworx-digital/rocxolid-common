<?php

namespace Softworx\RocXolid\Common\Models;

// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts as rxContracts;
// rocXolid model traits
use Softworx\RocXolid\Models\Traits as rxTraits;
// rocXolid models
use Softworx\RocXolid\Models\AbstractCrudModel;

// @todo CRUDable type necessary because Error can be sent by notification (communication package) - refactor
class Error extends AbstractCrudModel implements rxContracts\HasTokenablePropertiesMethods
{
    use rxTraits\HasTokenablePropertiesMethods;

    protected static $tokenable_methods = [
        'appName',
        'content',
    ];

    protected $exception;

    public function appName()
    {
        return env('APP_NAME');
    }

    public function setException(\Throwable $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    public function getException(): ?\Throwable
    {
        return $this->exception;
    }

    public function content(): string
    {
        return $this->getModelViewerComponent()->fetch('show');
    }
}
